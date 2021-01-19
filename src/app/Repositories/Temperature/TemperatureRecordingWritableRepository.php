<?php

namespace App\Repositories\Temperature;

use App\Models\TemperatureRecording;
use App\Repositories\Temperature\DTOs\TemperatureRecordingDTO;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TemperatureRecordingWritableRepository
{
    /**
     * @param \Illuminate\Support\Collection $batch
     */
    public function batchInsert(Collection $batch): void {
        TemperatureRecording::upsert(
            $batch->map(
                static function(TemperatureRecordingDTO $row) {
                    return [
                        'temp' => $row->getTemperature(),
                        'date_at' => $row->getRecordedAt()
                    ];
                }
            )
                ->toArray(),
            ['date_at'],
            ['temp']
        );
    }

    /**
     * @param float     $temperature
     * @param \DateTime $date
     */
    public function recordTemperature(float $temperature, DateTime $date): TemperatureRecording {
        $recording = TemperatureRecording::updateOrCreate(
            ['date_at' => $date],
            ['temp' => $temperature]
        );

        Cache::forever("temperature:${recording['id']}", $recording);
        Cache::put("temperature:${recording['date_at']}", $recording['id']);

        return $recording;
    }
}
