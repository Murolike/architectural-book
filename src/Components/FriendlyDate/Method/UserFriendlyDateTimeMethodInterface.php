<?php

namespace components\friendlyDate\method;

interface UserFriendlyDateTimeMethodInterface
{
    public function getDate(\DateTime $userDateTime): ?string;

    public function getCapitalizedDate(\DateTime $userDateTime): ?string;

    public function isDayBeforeYesterday(\DateTime $userDateTime): bool;

    public function isDayAfterTomorrow(\DateTime $userDateTime): bool;

    public function isTomorrow(\DateTime $userDateTime): bool;

    public function isYesterday(\DateTime $userDateTime): bool;

    public function isToday(\DateTime $userDateTime): bool;
}