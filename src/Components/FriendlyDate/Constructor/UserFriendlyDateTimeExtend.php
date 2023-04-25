<?php

namespace Murolike\Book\Components\FriendlyDate\Constructor;

use DateTime;

/**
 * Наследование
 * Задача "Реализовать расширение функционала" - "Наследование"
 */
class UserFriendlyDateTimeExtend extends UserFriendlyDateTime
{
    protected DateTime $twoWeeksAgo;
    protected DateTime $twoWeeksLater;

    public function __construct(DateTime $userDateTime)
    {
        parent::__construct($userDateTime);

        $this->twoWeeksAgo = new DateTime('-2 weeks midnight');
        $this->twoWeeksLater = new DateTime('+2 weeks midnight');
    }

    /**
     * @return string|null
     * @todo если нет нужного варианта, хотелось бы вернуть свою дату
     */
    public function getDate(): ?string
    {
        $value = parent::getDate();

        if ($this->isTwoWeeksAgo()) {
            $value = 'две недели назад';
        }
        if ($this->isTwoWeeksLater()) {
            $value = 'через две недели';
        }

        return $value;
    }

    /**
     * @return bool
     */
    public function isTwoWeeksAgo(): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($this->userDateTime);
        return $this->twoWeeksAgo === $userDateTime;
    }

    /**
     * @return bool
     */
    public function isTwoWeeksLater(): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($this->userDateTime);
        return $this->twoWeeksLater === $userDateTime;
    }
}