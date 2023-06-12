<?php

namespace Murolike\Book\FriendlyDate\ChainOfResponsibilities\handlers;

use DateTime;
use DateTimeZone;

abstract class DateHandler
{
    public function __construct(private readonly ?DateHandler $successor = null)
    {
    }

    final public function handle(DateTime $userDateTime): string
    {
        $processed = $this->processing($userDateTime);

        if ($processed === null && $this->successor !== null) {
            $processed = $this->successor->handle($userDateTime);
        }

        return $processed ?? $this->defaultProcessing($userDateTime);
    }

    abstract protected function processing(DateTime $userDateTime): ?string;

    protected function defaultProcessing(DateTime $userDateTime): string
    {
        return $userDateTime->format('d/m/y H:i');
    }

    protected function getUserDateTimeZone(DateTime $userDateTime): ?DateTimeZone
    {
        $userDateTimeZone = $userDateTime->getTimezone();

        return $userDateTimeZone ?: null;
    }

    protected function getUserMidnightTime(DateTime $userDateTime): DateTime
    {
        return (clone $userDateTime)->setTime(0, 0);
    }

}
