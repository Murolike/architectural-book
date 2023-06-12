<?php

namespace Murolike\Book\FriendlyDate\ChainOfResponsibilities;

use DateTime;

interface UserFriendlyDateTimeInterface
{
    /**
     * @param DateTime $userDateTime
     * @return string
     */
    public function getDate(DateTime $userDateTime): string;
}
