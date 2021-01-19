<?php

namespace App\Repositories\Temperature\Exceptions;

use DateTimeInterface;
use Exception;

class NoRecordingsAvailableForSelectedDatesException extends Exception
{
    protected DateTimeInterface $dateA;
    protected DateTimeInterface $dateB;

    /**
     * NoRecordingsAvailableForSelectedDatesException constructor.
     *
     * @param \DateTimeInterface $dateA
     * @param \DateTimeInterface $dateB
     */
    public function __construct(DateTimeInterface $dateA, DateTimeInterface $dateB)
    {
        parent::__construct(
            sprintf(
                'No temperature recordings available during period %s - %s',
                $dateA->format('d-m-Y'),
                $dateB->format('d-m-Y'),
            ),
            402
        );

        $this->dateA = $dateA;
        $this->dateB = $dateB;
    }


    /**
     * @return \DateTimeInterface
     */
    public function getDateA(): DateTimeInterface
    {
        return $this->dateA;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateB(): DateTimeInterface
    {
        return $this->dateB;
    }
}
