<?php

namespace App\Http\Decorators\Weather;

use App\Contracts\ResponseDecoratorContract;
use App\Models\TemperatureRecording;

class WeatherRecordingResponseDecorator implements ResponseDecoratorContract
{
    /** @var TemperatureRecording */
    protected $recording;

    /**
     * WeatherRecordingResponseDecorator constructor.
     *
     * @param \App\Models\TemperatureRecording $recording
     */
    public function __construct(TemperatureRecording $recording)
    {
        $this->recording = $recording;
    }

    /**
     * @return float
     */
    public function decorate(): float
    {
        return $this->recording['temp'];
    }
}
