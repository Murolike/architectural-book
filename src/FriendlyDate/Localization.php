<?php

declare(strict_types=1);

namespace Murolike\Book\FriendlyDate;

/**
 * Класс локализации
 */
class Localization
{
    /**
     * @param string $locale Локализация
     * @param array $dictionaries Словари
     */
    public function __construct(protected string $locale, protected array $dictionaries)
    {
    }

    /**
     * Получить локальное название слова
     * @param string $word
     * @return string
     */
    public function getLocaleWord(string $word): string
    {
        return $this->dictionaries[$this->locale][$word] ?? '-';
    }
}
