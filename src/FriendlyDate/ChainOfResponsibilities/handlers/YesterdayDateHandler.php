<?php

namespace Murolike\Book\FriendlyDate\ChainOfResponsibilities\handlers;

use DateTime;
use Exception;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;

class YesterdayDateHandler extends DateHandler
{

    /**
     * @throws Exception
     */
    protected function processing(DateTime $userDateTime): ?string
    {
        $yesterday = new DateTime('yesterday', $this->getUserDateTimeZone($userDateTime));

        if ($yesterday == $this->getUserMidnightTime($userDateTime)) {
            return UserFriendlyDateTimeText::yesterday->value;
        }

        return null;
    }
}
