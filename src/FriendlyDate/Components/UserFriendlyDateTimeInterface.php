<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate\Components;

/**
 * Интерфейс класса для преобразования даты в текст
 */
interface UserFriendlyDateTimeInterface
{
    /**
     * Получить дату в формате текста
     * @return string|null Возвращает текст, если смог найти подходящий шаблон, иначе null
     */
    public function getDate(\DateTime $userDateTime): ?string;

    /**
     * Проверка на позавчерашний день
     * @return bool Возвращает true, если это позавчерашний день
     */
    public function isDayBeforeYesterday(\DateTime $userDateTime): bool;

    /**
     * Проверка на послезавтрашний день
     * @return bool Возвращает true, если это послезавтрашний день
     */
    public function isDayAfterTomorrow(\DateTime $userDateTime): bool;

    /**
     * Проверка на завтрашний день
     * @return bool Возвращает true, если это завтрашний день
     */
    public function isTomorrow(\DateTime $userDateTime): bool;

    /**
     * Проверка на вчерашний день
     * @return bool Возвращает true, если это вчерашний день
     */
    public function isYesterday(\DateTime $userDateTime): bool;

    /**
     * Проверка на текущий день
     * @return bool Возвращает true, если это текущий день
     */
    public function isToday(\DateTime $userDateTime): bool;
}