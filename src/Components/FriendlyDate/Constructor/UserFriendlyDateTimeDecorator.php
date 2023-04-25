<?php

namespace Murolike\Book\Components\FriendlyDate\Constructor;

use DateTime;

/**
 * Декоратор для основного класса - <b>ПЛОХОЕ РЕШЕНИЕ</b>
 * Задача "Реализовать расширение функционала" - "Декоратор"
 */
class UserFriendlyDateTimeDecorator
{
    protected DateTime $twoWeeksAgo;
    protected DateTime $twoWeeksLater;

    public function __construct(private readonly UserFriendlyDateTime $userFriendlyDateTimeConstructor)
    {
        $this->twoWeeksAgo = new DateTime('-2 weeks midnight');
        $this->twoWeeksLater = new DateTime('+2 weeks midnight');
    }

    /**
     * @return string|null
     * @todo если нет нужного варианта, хотелось бы вернуть свою дату
     */
    public function getDate(): ?string
    {
        $value = $this->userFriendlyDateTimeConstructor->getDate();

        if (!$value) { // @todo НП: лишняя проверка
            return $value;
        }
        // @todo НП: нет доступа к данным объекта, то есть какое время мы не узнаем
        // $this->userFriendlyDateTimeConstructor->userDateTime
        // @todo НП: нужно писать лишний метод для преобразования к 00:00:00 формату, так как в объекте заблокирован
        // $this->userFriendlyDateTimeConstructor->castUserDateTimeToMidnight(DateTime $userDateTime)


        return $value;
    }
}