<?php

namespace App\Repositories\Temperature;

use App\Models\TemperatureRecording;
use App\Repositories\Temperature\Exceptions\NoRecordingsAvailableForSelectedDate;
use App\Repositories\Temperature\Exceptions\NoRecordingsAvailableForSelectedDatesException;
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
    public function queryById(int $id): ?TemperatureRecording
    {
        return Cache::rememberForever(
            "temperature:$id",
            static fn() => TemperatureRecording::find($id)
        );
    }

    /**
     * @param \DateTimeInterface $date
     * @return TemperatureRecording
     * @throws \App\Repositories\Temperature\Exceptions\NoRecordingsAvailableForSelectedDate
     */
    public function queryForDate(DateTimeInterface $date): TemperatureRecording
    {
        if (!$date instanceof Carbon) {
            $date = new Carbon($date);
        }

        $recording = Cache::rememberForever(
            "temperature:$date",
            static fn() => TemperatureRecording::where('date_at', $date)
                ->first(['id'])
        );

        if ($recording === null) {
            throw new NoRecordingsAvailableForSelectedDate($date);
        }

        return $this->queryById($recording['id']);
    }

    /**
     * @param \DateTimeInterface $dateA
     * @param \DateTimeInterface $dateB
     * @return \Illuminate\Support\Collection|TemperatureRecording[]
     * @throws \App\Repositories\Temperature\Exceptions\NoRecordingsAvailableForSelectedDatesException
     */
    public function queryBetweenDates(DateTimeInterface $dateA, DateTimeInterface $dateB): Collection
    {
        if (!$dateA instanceof Carbon) {
            $dateA = new Carbon($dateA);
        }

        if (!$dateB instanceof Carbon) {
            $dateB = new Carbon($dateB);
        }

        if ($dateA->gt($dateB)) {
            $buffer = $dateB;
            $dateB = &$dateA;
            $dateA = &$buffer;

            unset($buffer);
        }

        /** @var Collection $recordings */
        $recordings = Cache::tags('minor')
            ->remember(
                sprintf("temperature:%s-%s", $dateA->toDateString(), $dateB->toDateString()),
                new DateInterval('PT2H'),
                fn() => TemperatureRecording::whereBetween('date_at', [$dateA, $dateB])
                    ->get(['id'])
                    ->pluck('id')
            );

        if ($recordings === null || $recordings->isEmpty()) {
            throw new NoRecordingsAvailableForSelectedDatesException($dateA, $dateB);
        }

        return $recordings->map(
            fn(int $id) => $this->queryById($id)
        );
    }
}
