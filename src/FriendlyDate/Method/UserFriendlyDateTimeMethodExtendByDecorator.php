<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate\Method;

/**
 * Декоратор для класса преобразовывающий дату в текст
 * Задача "Реализовать расширение функционала" - "Декоратор"
 */
class UserFriendlyDateTimeMethodExtendByDecorator implements CapitalizedUserFriendlyDateTimeInterface
{
    /**
     * Формат даты
     * @var string
     */
    protected string $dateTimeFormat = 'd.m.Y';

    /**
     * @param CapitalizedUserFriendlyDateTimeInterface $userFriendlyDateTimeMethod
     */
    public function __construct(protected CapitalizedUserFriendlyDateTimeInterface $userFriendlyDateTimeMethod)
    {
    }

    /**
     * @inheritdoc
     */
    public function getDate(\DateTime $userDateTime): ?string
    {
        return $this->userFriendlyDateTimeMethod->getDate($userDateTime);
    }

    public function getCapitalizedDate(\DateTime $userDateTime): ?string
    {
        return $this->userFriendlyDateTimeMethod->getCapitalizedDate($userDateTime);
    }

    public function isDayBeforeYesterday(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isDayBeforeYesterday($userDateTime);
    }

    public function isDayAfterTomorrow(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isDayAfterTomorrow($userDateTime);
    }

    public function isTomorrow(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isTomorrow($userDateTime);
    }

    public function isYesterday(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isYesterday($userDateTime);
    }

    public function isToday(\DateTime $userDateTime): bool
    {
        return $this->userFriendlyDateTimeMethod->isToday($userDateTime);
    }
}