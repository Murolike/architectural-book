<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate\Components;

/**
 * Интерфейс для преобразования к верхнему регистру
 */
interface CapitalizedUserFriendlyDateTimeInterface
{
    /**
     * Получить дату в формате текста с заглавной
     * @return string|null Возвращает текст, если смог найти подходящий шаблон, иначе null
     */
    public function getCapitalizedDate(\DateTime $userDateTime): ?string;
}