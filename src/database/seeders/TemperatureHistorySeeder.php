<?php

namespace Database\Seeders;

use App\Repositories\Temperature\DTOs\TemperatureRecordingDTO;
use App\Repositories\Temperature\TemperatureRecordingWritableRepository;
use Illuminate\Database\Seeder;
use Str;

class TemperatureHistorySeeder extends Seeder
{
    /** @var \App\Repositories\Temperature\TemperatureRecordingWritableRepository */
    protected $tempRecordingWriteableRepo;

    /**
     * TemperatureHistorySeeder constructor.
     *
     * @param \App\Repositories\Temperature\TemperatureRecordingWritableRepository $tempRecordingWriteableRepo
     */
    public function __construct(TemperatureRecordingWritableRepository $tempRecordingWriteableRepo)
    {
        $this->tempRecordingWriteableRepo = $tempRecordingWriteableRepo;
    }

    /**
     * @return float
     * @throws \Exception
     */
    protected function generateRandomTemp(): float {
        $decimals = random_int(0, 250);
        return random_int(-40, 40) + $decimals / (10 * Str::length((string) $decimals));
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $cursor = now();
        $endBy = now()->subMonths(6);

        $inserts = collect();

        do {
            $inserts->push(
                (new TemperatureRecordingDTO)
                    ->setRecordedAt($cursor->copy())
                    ->setTemperature($this->generateRandomTemp())
            );

            $cursor->subDay();
        } while ($cursor->gte($endBy));

        $this->tempRecordingWriteableRepo->batchInsert($inserts);
    }
}
