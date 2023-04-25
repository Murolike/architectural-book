<?php

declare(strict_types=1);

namespace components\friendlyDate\method;

use DateTime;

class UserFriendlyDateTimeMethodExtend extends UserFriendlyDateTimeMethod implements UserFriendlyDateTimeMethodInterface
{
    protected DateTime $twoWeeksAgo;
    protected DateTime $twoWeeksLater;

    public function __construct()
    {
        parent::__construct();

        $this->twoWeeksAgo = new DateTime('-2 weeks midnight');
        $this->twoWeeksLater = new DateTime('+2 weeks midnight');
    }

    /**
     * @param DateTime $userDateTime
     * @return string|null
     * @todo если нужно добавить "через одну/две недели", при наследовании данного метода, как делать?
     */
    public function getDate(DateTime $userDateTime): ?string
    {
        $value = parent::getDate($userDateTime);

        if ($this->isTwoWeeksAgo($userDateTime)) {
            $value = 'две недели назад';
        }
        if ($this->isTwoWeeksLater($userDateTime)) {
            $value = 'через две недели';
        }

        return $value;
    }

    /**
     * @param DateTime $userDateTime
     * @return bool
     */
    public function isTwoWeeksAgo(DateTime $userDateTime): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($userDateTime);
        return $this->twoWeeksAgo === $userDateTime;
    }

    /**
     * @param DateTime $userDateTime
     * @return bool
     */
    public function isTwoWeeksLater(DateTime $userDateTime): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($userDateTime);
        return $this->twoWeeksLater === $userDateTime;
    }
}
