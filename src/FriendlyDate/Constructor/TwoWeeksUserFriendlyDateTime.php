<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate\Constructor;

use DateTime;
use DateTimeZone;
use Exception;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;

/**
 * Расширенный класс для преобразования даты в текст
 * Задача "Реализовать расширение функционала" - "Наследование"
 */
class TwoWeeksUserFriendlyDateTime extends UserFriendlyDateTime
{
    /**
     * Две недели назад
     * @var DateTime
     */
    protected readonly DateTime $twoWeeksAgo;

    /**
     * Две недели спустя
     * @var DateTime
     */
    protected readonly DateTime $twoWeeksLater;

    /**
     * @param DateTime $userDateTime
     * @throws Exception
     */
    public function __construct(DateTime $userDateTime)
    {
        parent::__construct($userDateTime);

        /** @var DateTimeZone|false $userDateTimeZone */
        $userDateTimeZone = $this->userDateTime->getTimezone();
        $userDateTimeZone = $userDateTimeZone ?: null;

        $this->twoWeeksAgo = new DateTime('-2 weeks midnight', $userDateTimeZone);
        $this->twoWeeksLater = new DateTime('+2 weeks midnight', $userDateTimeZone);
    }

    /**
     * @inheritdoc
     */
    public function getDate(): ?string
    {
        $value = parent::getDate();

        if ($this->isTwoWeeksAgo()) {
            $value = UserFriendlyDateTimeText::twoWeekAgo->value;
        }
        if ($this->isTwoWeeksLater()) {
            $value = UserFriendlyDateTimeText::twoWeekLater->value;
        }

        return $value;
    }

    /**
     * Проверка на две недели назад
     * @return bool Возвращает true, если это две недели назад
     */
    public function isTwoWeeksAgo(): bool
    {
        return $this->twoWeeksAgo == $this->userDateTimeMidnight;
    }

    /**
     * Проверка на две недели после
     * @return bool Возвращает true, если это две недели после
     */
    public function isTwoWeeksLater(): bool
    {
        return $this->twoWeeksLater == $this->userDateTimeMidnight;
    }
}