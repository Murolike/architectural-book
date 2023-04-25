<?php

declare(strict_types=1);

namespace Murolike\Book\Components\FriendlyDate\Constructor;

use DateTime;
use Murolike\Book\Components\FriendlyDate\UserFriendlyDateTimeText;

class UserFriendlyDateTime
{
    protected readonly DateTime $today;
    protected readonly DateTime $dayBeforeYesterday;
    protected readonly DateTime $yesterday;
    protected readonly DateTime $tomorrow;
    protected readonly DateTime $dayAfterTomorrow;

    /**
     * @param DateTime $userDateTime
     * @todo Передаем в конструктор $userDateTime, а если у нас будет работа с множеством $userDateTime - создавать много объектов?
     */
    public function __construct(protected readonly DateTime $userDateTime)
    {
        $this->today = new DateTime('today');
        $this->dayBeforeYesterday = new DateTime('yesterday -1 day');
        $this->yesterday = new DateTime('yesterday');
        $this->tomorrow = new DateTime('tomorrow');
        $this->dayAfterTomorrow = new DateTime('tomorrow +1 day');
    }

    /**
     * @return string|null
     * @todo если нет нужного варианта, хотелось бы вернуть свою дату
     */
    public function getDate(): ?string
    {
        $value = null;

        if ($this->isCurrentDay()) {
            $value = UserFriendlyDateTimeText::today->value;
        }
        if ($this->isYesterday()) {
            $value = UserFriendlyDateTimeText::yesterday->value;
        }
        if ($this->isTomorrow()) {
            $value = UserFriendlyDateTimeText::tomorrow->value;
        }
        if ($this->isDayAfterTomorrow()) {
            $value = UserFriendlyDateTimeText::dayAfterTomorrow->value;
        }
        if ($this->isDayBeforeYesterday()) {
            $value = UserFriendlyDateTimeText::dayBeforeYesterday->value;
        }

        return $value;
    }

    /**
     * @return string|null
     */
    public function getCapitalizedDate(): ?string
    {
        $value = $this->getDate();
        if ($value) {
            $value = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
        }
        return $value;
    }

    public function isDayBeforeYesterday(): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($this->userDateTime);

        return $this->dayBeforeYesterday == $userDateTime;
    }

    public function isDayAfterTomorrow(): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($this->userDateTime);

        return $this->dayAfterTomorrow == $userDateTime;
    }

    public function isTomorrow(): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($this->userDateTime);

        return $this->tomorrow == $userDateTime;
    }

    public function isYesterday(): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($this->userDateTime);

        return $this->yesterday == $userDateTime;
    }

    /**
     * Текущий ли день (проверяет день, месяц, год)
     * @return bool Возвращает true, если текущий день, иначе false
     */
    public function isCurrentDay(): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($this->userDateTime);

        return $this->today == $userDateTime;
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
