<?php

namespace Murolike\Book\FriendlyDate\ChainOfResponsibilities\handlers;

use DateTime;
use Exception;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;

class TomorrowDateHandler extends DateHandler
{

    /**
     * @throws Exception
     */
    protected function processing(DateTime $userDateTime): ?string
    {
        $tomorrow = new DateTime('tomorrow', $this->getUserDateTimeZone($userDateTime));

        if ($tomorrow == $this->getUserMidnightTime($userDateTime)) {
            return UserFriendlyDateTimeText::tomorrow->value;
        }

        return null;
    }
}
