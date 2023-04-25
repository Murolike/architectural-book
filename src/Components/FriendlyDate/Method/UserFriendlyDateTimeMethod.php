<?php

declare(strict_types=1);

namespace components\friendlyDate\method;

use DateTime;
use components\friendlyDate\UserFriendlyDateTimeText;

class UserFriendlyDateTimeMethod implements UserFriendlyDateTimeMethodInterface
{
    private readonly DateTime $today;
    private readonly DateTime $dayBeforeYesterday;
    private readonly DateTime $yesterday;
    private readonly DateTime $tomorrow;
    private readonly DateTime $dayAfterTomorrow;

    /**
     *
     */
    public function __construct()
    {
        $this->today = new DateTime('today');
        $this->dayBeforeYesterday = new DateTime('yesterday -1 day');
        $this->yesterday = new DateTime('yesterday');
        $this->tomorrow = new DateTime('tomorrow');
        $this->dayAfterTomorrow = new DateTime('tomorrow +1 day');
    }

    /**
     * @param DateTime $userDateTime
     * @return string|null
     * @todo если нет нужного варианта, хотелось бы вернуть свою дату
     * @todo если нужно добавить "через одну/две недели", при наследовании данного метода, как делать?
     */
    public function getDate(DateTime $userDateTime): ?string
    {
        $value = null;

        if ($this->isToday($userDateTime)) {
            $value = UserFriendlyDateTimeText::today->value;
        }
        if ($this->isYesterday($userDateTime)) {
            $value = UserFriendlyDateTimeText::yesterday->value;
        }
        if ($this->isTomorrow($userDateTime)) {
            $value = UserFriendlyDateTimeText::tomorrow->value;
        }
        if ($this->isDayAfterTomorrow($userDateTime)) {
            $value = UserFriendlyDateTimeText::dayAfterTomorrow->value;
        }
        if ($this->isDayBeforeYesterday($userDateTime)) {
            $value = UserFriendlyDateTimeText::dayBeforeYesterday->value;
        }

        return $value;
    }

    /**
     * @param DateTime $userDateTime
     * @return string|null
     */
    public function getCapitalizedDate(DateTime $userDateTime): ?string
    {
        $value = $this->getDate($userDateTime);
        if ($value) {
            $value = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
        }
        return $value;
    }

    public function isDayBeforeYesterday(DateTime $userDateTime): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($userDateTime);

        return $this->dayBeforeYesterday === $userDateTime;
    }

    public function isDayAfterTomorrow(DateTime $userDateTime): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($userDateTime);

        return $this->dayAfterTomorrow === $userDateTime;
    }

    public function isTomorrow(DateTime $userDateTime): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($userDateTime);

        return $this->tomorrow === $userDateTime;
    }

    public function isYesterday(DateTime $userDateTime): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($userDateTime);

        return $this->yesterday === $userDateTime;
    }

    /**
     * Текущий ли день (проверяет день, месяц, год)
     * @return bool Возвращает true, если текущий день, иначе false
     */
    public function isToday(DateTime $userDateTime): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($userDateTime);

        return $this->today === $userDateTime;
    }

    /**
     * @param DateTime $userDateTime
     * @return DateTime
     * @todo переименовать
     */
    protected function castUserDateTimeToMidnight(DateTime $userDateTime)
    {
        return $userDateTime->setTime(0, 0);
    }
}
