<?php

namespace App\Repositories\Temperature\Exceptions;

use DateTimeInterface;
use Exception;

class NoRecordingsAvailableForSelectedDate extends Exception
{
    /** @var \DateTimeInterface */
    protected $date;

    /**
     * NoRecordingsAvailableForSelectedDate constructor.
     *
     * @param \DateTimeInterface $date
     */
    public function __construct(DateTimeInterface $date)
    {
        parent::__construct(sprintf("No temperature recordings found on %s", $date->format('d-m-Y')), 402);
        $this->date = $date;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }
}
