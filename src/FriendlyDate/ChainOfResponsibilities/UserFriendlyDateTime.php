<?php

namespace Murolike\Book\FriendlyDate\ChainOfResponsibilities;

use DateTime;
use Murolike\Book\FriendlyDate\ChainOfResponsibilities\handlers\DateHandler;
use Murolike\Book\FriendlyDate\ChainOfResponsibilities\handlers\TodayDateHandler;
use Murolike\Book\FriendlyDate\ChainOfResponsibilities\handlers\TomorrowDateHandler;
use Murolike\Book\FriendlyDate\ChainOfResponsibilities\handlers\YesterdayDateHandler;

class UserFriendlyDateTime implements UserFriendlyDateTimeInterface
{
    protected DateHandler $handler;

    public function __construct()
    {
        $tomorrowHandler = new TomorrowDateHandler();
        $yesterdayHandler = new YesterdayDateHandler($tomorrowHandler);
        $this->handler = new TodayDateHandler($yesterdayHandler);
    }

    public function getDate(DateTime $userDateTime): string
    {
        return $this->handler->handle($userDateTime);
    }

}
