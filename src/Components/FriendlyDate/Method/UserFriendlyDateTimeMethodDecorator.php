<?php

namespace components\friendlyDate\method;

class UserFriendlyDateTimeMethodDecorator implements UserFriendlyDateTimeMethodInterface
{
    public function __construct(protected UserFriendlyDateTimeMethodInterface $userFriendlyDateTimeMethod)
    {
    }

    /**
     * @param \DateTime $userDateTime
     * @return string|null
     * @todo если нужно добавить "через одну/две недели", при наследовании данного метода, как делать?
     */
    public function getDate(\DateTime $userDateTime): ?string
    {
        return $this->userFriendlyDateTimeMethod->getDate($userDateTime);
    }

    public function getCapitalizedDate(\DateTime $userDateTime): ?string
    {
        return $this->userFriendlyDateTimeMethod->getCapitalizedDate($userDateTime);
    }

    public function isDayBeforeYesterday(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isDayBeforeYesterday($userDateTime);
    }

    public function isDayAfterTomorrow(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isDayAfterTomorrow($userDateTime);
    }

    public function isTomorrow(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isTomorrow($userDateTime);
    }

    public function isYesterday(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isYesterday($userDateTime);
    }

    public function isToday(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isToday($userDateTime);
    }
}