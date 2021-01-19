<?php

namespace App\Http\Decorators\Weather;

use App\Contracts\ResponseDecoratorContract;
use App\Models\TemperatureRecording;
use Illuminate\Support\Collection;

class WeatherRecordingCollectionResponseDecorator implements ResponseDecoratorContract
{
    /** @var \Illuminate\Support\Collection */
    protected $recordings;

    /**
     * WeatherRecordingCollectionResponseDecorator constructor.
     *
     * @param \Illuminate\Support\Collection $recordings
     */
    public function __construct(Collection $recordings)
    {
        $this->recordings = $recordings;
    }

    public function decorate()
    {
        return $this->recordings->keyBy(
            static fn(TemperatureRecording $recording) => $recording['date_at']->format('d-m-Y')
        )
            ->map(
                static fn(TemperatureRecording $recording) =>
                    (new WeatherRecordingResponseDecorator($recording))->decorate()
            );
    }
}
