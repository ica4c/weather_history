<?php

namespace App\Repositories\Temperature\DTOs;

use DateTimeInterface;

class TemperatureRecordingDTO
{
    /** @var float */
    protected $temperature;
    /** @var \DateTimeInterface */
    protected $recordedAt;

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @param float $temperature
     * @return self
     */
    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getRecordedAt(): DateTimeInterface
    {
        return $this->recordedAt;
    }

    /**
     * @param \DateTimeInterface $recordedAt
     * @return self
     */
    public function setRecordedAt(DateTimeInterface $recordedAt): self
    {
        $this->recordedAt = $recordedAt;
        return $this;
    }
}
