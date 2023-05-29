<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate\Method;

use DateTime;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;

/**
 * Расширенный класс для преобразования даты в текст
 * Задача "Реализовать расширение функционала" - "Наследование"
 */
class UserFriendlyDateTimeMethodExtendByInherit extends UserFriendlyDateTimeMethod
{
    /**
     * Две недели ранее
     * @var DateTime
     */
    protected DateTime $twoWeeksAgo;

    /**
     * Две недели позднее
     * @var DateTime
     */
    protected DateTime $twoWeeksLater;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();

        $this->twoWeeksAgo = new DateTime('-2 weeks midnight');
        $this->twoWeeksLater = new DateTime('+2 weeks midnight');
    }

    /**
     * @inheritdoc
     */
    public function getDate(DateTime $userDateTime): ?string
    {
        $userDateTimeMidnight = $this->setMidnightTime($userDateTime);
        $value = parent::getDate($userDateTime);

        if ($this->isTwoWeeksAgo($userDateTimeMidnight)) {
            $value = UserFriendlyDateTimeText::twoWeekAgo->value;
        }
        if ($this->isTwoWeeksLater($userDateTimeMidnight)) {
            $value = UserFriendlyDateTimeText::twoWeekLater->value;
        }

        return $value;
    }

    /**
     * Проверка на две недели ранее
     * @param DateTime $userDateTime
     * @return bool
     */
    public function isTwoWeeksAgo(DateTime $userDateTime): bool
    {
        return $this->twoWeeksAgo == $userDateTime;
    }

    /**
     * Проверка на две недели позднее
     * @param DateTime $userDateTime
     * @return bool
     */
    public function isTwoWeeksLater(DateTime $userDateTime): bool
    {
        return $this->twoWeeksLater == $userDateTime;
    }
}
