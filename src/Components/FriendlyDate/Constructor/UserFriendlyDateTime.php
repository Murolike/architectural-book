<?php

declare(strict_types=1);

namespace Murolike\Book\Components\FriendlyDate\Constructor;

use DateTime;
use Murolike\Book\Components\FriendlyDate\UserFriendlyDateTimeText;

/**
 * Класс для преобразования даты в текст
 * @todo Это не компонент, так как он будет создаваться для каждой даты, что теряет возможность многократного его использования
 */
class UserFriendlyDateTime
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
     * @param DateTime $userDateTime Пользовательское время
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
     * Получить дату в формате текста
     * @return string|null Возвращает текст, если смог найти подходящий шаблон, иначе null
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
     * Получить дату в формате текста (с заглавной)
     * @return string|null Возвращает текст, если смог найти подходящий шаблон, иначе null
     */
    public function getCapitalizedDate(): ?string
    {
        $value = $this->getDate();
        if ($value) {
            $value = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
        }
        return $value;
    }

    /**
     * Проверка на позавчерашний день
     * @return bool Возвращает true, если это позавчерашний день
     */
    public function isDayBeforeYesterday(): bool
    {
        $userDateTime = $this->setMidnightTime($this->userDateTime);

        return $this->dayBeforeYesterday == $userDateTime;
    }

    /**
     * Проверка на послезавтрашний день
     * @return bool Возвращает true, если это послезавтрашний день
     */
    public function isDayAfterTomorrow(): bool
    {
        $userDateTime = $this->setMidnightTime($this->userDateTime);

        return $this->dayAfterTomorrow == $userDateTime;
    }

    /**
     * Проверка на завтрашний день
     * @return bool Возвращает true, если это завтрашний день
     */
    public function isTomorrow(): bool
    {
        $userDateTime = $this->setMidnightTime($this->userDateTime);

        return $this->tomorrow == $userDateTime;
    }

    /**
     * Проверка на вчерашний день
     * @return bool Возвращает true, если это вчерашний день
     */
    public function isYesterday(): bool
    {
        $userDateTime = $this->setMidnightTime($this->userDateTime);

        return $this->yesterday == $userDateTime;
    }

    /**
     * Проверка на текущий день
     * @return bool Возвращает true, если это текущий день
     */
    public function isCurrentDay(): bool
    {
        $userDateTime = $this->setMidnightTime($this->userDateTime);

        return $this->today == $userDateTime;
    }

    /**
     * Преобразывает время к полночи
     * @param DateTime $userDateTime
     * @return DateTime Возвращает пользовательскую дату с установленным времен на полночи
     */
    protected function setMidnightTime(DateTime $userDateTime): DateTime
    {
        return $userDateTime->setTime(0, 0);
    }
}
