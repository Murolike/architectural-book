<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate\Constructor;

use DateTime;
use DateTimeZone;
use Exception;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;

/**
 * Класс для преобразования даты в текст
 * Задача "Реализовать класс для вывода даты в текстовом формате"
 */
class UserFriendlyDateTime implements UserFriendlyDateTimeInterface
{
    /**
     * Текущая дата
     * @var DateTime
     */
    protected readonly DateTime $today;

    /**
     * Позавчера
     * @var DateTime
     */
    protected readonly DateTime $dayBeforeYesterday;

    /**
     * Вчера
     * @var DateTime
     */
    protected readonly DateTime $yesterday;

    /**
     * Завтра
     * @var DateTime
     */
    protected readonly DateTime $tomorrow;

    /**
     * После завтра
     * @var DateTime
     */
    protected readonly DateTime $dayAfterTomorrow;

    /**
     * Пользовательское время на полночь
     * @var DateTime
     */
    protected readonly DateTime $userDateTimeMidnight;

    /**
     * Конструктор
     * @param DateTime $userDateTime Пользовательское время
     * @throws Exception
     */
    public function __construct(protected readonly DateTime $userDateTime)
    {
        /** @var DateTimeZone|false $userDateTimeZone */
        $userDateTimeZone = $this->userDateTime->getTimezone();
        $userDateTimeZone = $userDateTimeZone ?: null;

        $this->today = new DateTime('today', $userDateTimeZone);
        $this->dayBeforeYesterday = new DateTime('yesterday -1 day', $userDateTimeZone);
        $this->yesterday = new DateTime('yesterday', $userDateTimeZone);
        $this->tomorrow = new DateTime('tomorrow', $userDateTimeZone);
        $this->dayAfterTomorrow = new DateTime('tomorrow +1 day', $userDateTimeZone);

        $this->userDateTimeMidnight = $this->setMidnightTime($this->userDateTime);
    }

    /**
     * @inheritdoc
     */
    public function getDate(): ?string
    {
        $value = null;

        if ($this->isToday()) {
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
     * @inheritdoc
     */
    public function isDayBeforeYesterday(): bool
    {
        return $this->dayBeforeYesterday == $this->userDateTimeMidnight;
    }

    /**
     * @inheritdoc
     */
    public function isDayAfterTomorrow(): bool
    {
        return $this->dayAfterTomorrow == $this->userDateTimeMidnight;
    }

    /**
     * @inheritdoc
     */
    public function isTomorrow(): bool
    {
        return $this->tomorrow == $this->userDateTimeMidnight;
    }

    /**
     * @inheritdoc
     */
    public function isYesterday(): bool
    {
        return $this->yesterday == $this->userDateTimeMidnight;
    }

    /**
     * @inheritdoc
     */
    public function isToday(): bool
    {
        return $this->today == $this->userDateTimeMidnight;
    }

    /**
     * Преобразывает время к полночи
     * @param DateTime $userDateTime
     * @return DateTime Возвращает пользовательскую дату с установленным временем на полночь
     */
    protected function setMidnightTime(DateTime $userDateTime): DateTime
    {
        $dateTime = clone $userDateTime;
        return $dateTime->setTime(0, 0);
    }
}
