<?php

namespace Murolike\Book\FriendlyDate\ChainOfResponsibilities\handlers;

use DateTime;
use Exception;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;

class TodayDateHandler extends DateHandler
{

    /**
     * @throws Exception
     */
    protected function processing(DateTime $userDateTime): ?string
    {
        $today = new DateTime('today', $this->getUserDateTimeZone($userDateTime));

        if ($today == $this->getUserMidnightTime($userDateTime)) {
            return UserFriendlyDateTimeText::today->value;
        }

        return null;
    }
}
