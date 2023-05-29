<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate\Constructor;

use DateTime;
use Exception;

/**
 * Расширенный класс для преобразования даты в текст
 * Задача "Реализовать вывод своей даты, если нет подходящей"
 */
class UserFriendlyDateTimeExtendedFormat extends UserFriendlyDateTime
{
    /**
     * Формат дат
     * @var string
     */
    protected string $defaultDateTimeFormat = 'd.m.Y';

    /**
     * @param DateTime $userDateTime
     * @throws Exception
     */
    public function __construct(DateTime $userDateTime)
    {
        parent::__construct($userDateTime);
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        $value = parent::getDate();

        if (null === $value) {
            $value = $this->userDateTime->format($this->defaultDateTimeFormat);
        }

        return $value;
    }
}