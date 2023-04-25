<?php

declare(strict_types=1);

namespace Murolike\Book\Components\FriendlyDate;

/**
 * Список вариантов вывода
 */
enum UserFriendlyDateTimeText: string
{
    case tomorrow = 'завтра';
    case yesterday = 'вчера';
    case today = 'сегодня';
    case dayBeforeYesterday = 'позавчера';
    case dayAfterTomorrow = 'после завтра';
}
