<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate\Components;

use DateTime;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;

/**
 * Класс для преобразования даты в текст
 * Задача "Реализовать класс для вывода даты в текстовом формате"
 * @todo таймзона
 */
class UserFriendlyDateTime implements UserFriendlyDateTimeInterface, CapitalizedUserFriendlyDateTimeInterface
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
     * Конструктор
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
     * @inheritdoc
     */
    public function getDate(DateTime $userDateTime): ?string
    {
        $userDateTimeMidnight = $this->setMidnightTime($userDateTime);
        $value = null;

        if ($this->isToday($userDateTimeMidnight)) {
            $value = UserFriendlyDateTimeText::today->value;
        }
        if ($this->isYesterday($userDateTimeMidnight)) {
            $value = UserFriendlyDateTimeText::yesterday->value;
        }
        if ($this->isTomorrow($userDateTimeMidnight)) {
            $value = UserFriendlyDateTimeText::tomorrow->value;
        }
        if ($this->isDayAfterTomorrow($userDateTimeMidnight)) {
            $value = UserFriendlyDateTimeText::dayAfterTomorrow->value;
        }
        if ($this->isDayBeforeYesterday($userDateTimeMidnight)) {
            $value = UserFriendlyDateTimeText::dayBeforeYesterday->value;
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function getCapitalizedDate(DateTime $userDateTime): ?string
    {
        $value = $this->getDate($userDateTime);
        if ($value) {
            $value = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
        }
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function isDayBeforeYesterday(DateTime $userDateTime): bool
    {
        return $this->dayBeforeYesterday == $userDateTime;
    }

    /**
     * @inheritdoc
     */
    public function isDayAfterTomorrow(DateTime $userDateTime): bool
    {
        return $this->dayAfterTomorrow == $userDateTime;
    }

    /**
     * @inheritdoc
     */
    public function isTomorrow(DateTime $userDateTime): bool
    {
        return $this->tomorrow == $userDateTime;
    }

    /**
     * @inheritdoc
     */
    public function isYesterday(DateTime $userDateTime): bool
    {
        return $this->yesterday == $userDateTime;
    }

    /**
     * @inheritdoc
     */
    public function isToday(DateTime $userDateTime): bool
    {
        return $this->today == $userDateTime;
    }

    /**
     * Преобразывает время к полночи
     * @param DateTime $userDateTime
     * @return DateTime Возвращает пользовательскую дату с установленным времен на полночь
     */
    protected function setMidnightTime(DateTime $userDateTime): DateTime
    {
        $dateTime = clone $userDateTime;
        return $dateTime->setTime(0, 0);
    }
}
