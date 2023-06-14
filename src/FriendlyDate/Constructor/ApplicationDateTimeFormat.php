<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate\Constructor;

use DateTime;
use Exception;

/**
 * Расширенный класс для преобразования даты в текст
 * Задача "Реализовать вывод своей даты, если нет подходящей"
 */
class ApplicationDateTimeFormat extends UserFriendlyDateTime
{
    /**
     * @param DateTime $userDateTime
     * @param string $defaultDateTimeFormat Формат даты
     * @throws Exception
     */
    public function __construct(DateTime $userDateTime, protected string $defaultDateTimeFormat = 'd.m.Y')
    {
        parent::__construct($userDateTime);
    }

    /**
     * @inheritdoc
     */
    public function getDate(): string
    {
        $value = parent::getDate();

        return $value ?? $this->userDateTime->format($this->defaultDateTimeFormat);
    }

    /**
     * Метод преобразует дату в тестовый формат, если нет интерпретации вернету дату в формате
     * @return string Вернет пытается вернуть текстовую интерпретацию или дату в формате
     */
    public function getDateTimeAsTextOrDate(): string
    {
        $date = parent::getDate();
        return $date ?? $this->userDateTime->format($this->defaultDateTimeFormat);
    }

    /**
     * Метод преобразует дату в текстовый формат, если нет интерпретации вернет дату в формате
     * @param string $dateTimeFormat
     * @return string Вернуть текстовую интерпретацию, если она есть или дату в формате
     */
    public function getDateTimeASTextOrDateByFormat(string $dateTimeFormat = 'd.m.Y'): string
    {
        $date = parent::getDate();
        return $date ?? $this->userDateTime->format($dateTimeFormat);
    }
}