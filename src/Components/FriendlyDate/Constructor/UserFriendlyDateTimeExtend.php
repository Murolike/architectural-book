<?php

declare(strict_types=1);

namespace Murolike\Book\Components\FriendlyDate\Constructor;

use DateTime;
use Murolike\Book\Components\FriendlyDate\UserFriendlyDateTimeText;

/**
 * Класс для преобразования даты в текст
 * Задача "Реализовать расширение функционала" - "Наследование"
 */
class UserFriendlyDateTimeExtend extends UserFriendlyDateTime
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
     */
    public function __construct(DateTime $userDateTime)
    {
        parent::__construct($userDateTime);

        $this->twoWeeksAgo = new DateTime('-2 weeks midnight');
        $this->twoWeeksLater = new DateTime('+2 weeks midnight');
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
        $userDateTime = $this->setMidnightTime($this->userDateTime);
        return $this->twoWeeksAgo === $userDateTime;
    }

    /**
     * Проверка на две недели после
     * @return bool Возвращает true, если это две недели после
     */
    public function isTwoWeeksLater(): bool
    {
        $userDateTime = $this->setMidnightTime($this->userDateTime);
        return $this->twoWeeksLater === $userDateTime;
    }
}