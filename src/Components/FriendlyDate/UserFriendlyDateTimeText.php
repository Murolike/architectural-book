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
    case twoWeekAgo = 'две недели назад';
    case twoWeekLater = 'через две недели';
}
