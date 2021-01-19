<?php

namespace App\Repositories\Temperature;

use App\Models\TemperatureRecording;
use Carbon\Carbon;
use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TemperatureRecordingReadRepository
{
    /**
     * @param int $id
     * @return \App\Models\TemperatureRecording|null
     */
    public function queryById(int $id): ?TemperatureRecording {
        return Cache::rememberForever(
            "temperature:$id",
            static function() use ($id) {
                return TemperatureRecording::find($id);
            }
        );
    }

    /**
     * @param \DateTimeInterface $date
     * @return Collection|TemperatureRecording[]
     */
    public function queryForDate(DateTimeInterface $date): Collection
    {
        if(!$date instanceof Carbon) {
            $date = new Carbon($date);
        }

        return Cache::rememberForever(
            "temperature:$date",
            static function() use ($date) {
                return TemperatureRecording::where('date_at', $date)
                    ->first(['id']);
            }
        )
            ->map(
                function(TemperatureRecording $recording) {
                    return $this->queryById($recording['id']);
                }
            );
    }

    /**
     * @param \DateTimeInterface $dateA
     * @param \DateTimeInterface $dateB
     * @return \Illuminate\Support\Collection|TemperatureRecording[]
     */
    public function queryBetweenDates(DateTimeInterface $dateA, DateTimeInterface $dateB): Collection
    {
        if(!$dateA instanceof Carbon) {
            $dateA = new Carbon($dateA);
        }

        if(!$dateB instanceof Carbon) {
            $dateB = new Carbon($dateB);
        }

        return Cache::remember(
            sprintf("temperature:%s-%s", $dateA->toDateString(), $dateB->toDateString()),
            new DateInterval('PT2H'),
            static function() use ($dateA, $dateB) {
                return TemperatureRecording::whereBetween('date_at', [$dateA, $dateB])
                    ->get(['id'])
                    ->pluck('id');
            }
        )
            ->map(
                function(TemperatureRecording $recording) {
                    return $this->queryById($recording['id']);
                }
            );
    }
}
