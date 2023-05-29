<?php

namespace unit\FriendlyDate\Constructor;

use DateTime;
use Exception;
use Murolike\Book\FriendlyDate\Constructor\UserFriendlyDateTimeExtendedFormat;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class UserFriendlyDateTimeExtendedFormatTest extends TestCase
{

    /**
     * Тест на получение даты в формате
     * @return void
     * @throws Exception
     */
    public function testGetDate()
    {
        $twoWeekAgoDateTime = new DateTime('-14 day');
        $twoDayAgoDateTime = new DateTime('-2 day');

        $twoWeekAgoUserFriendlyDateTime = new UserFriendlyDateTimeExtendedFormat($twoWeekAgoDateTime);
        $todayUserFriendlyDateTime = new UserFriendlyDateTimeExtendedFormat($twoDayAgoDateTime);


        self::assertEquals($twoWeekAgoDateTime->format('d.m.Y'), $twoWeekAgoUserFriendlyDateTime->getDate());
        self::assertNotEquals($twoDayAgoDateTime->format('d.m.Y'), $todayUserFriendlyDateTime->getDate());
        self::assertEquals(UserFriendlyDateTimeText::dayBeforeYesterday->value, $todayUserFriendlyDateTime->getDate());
    }
}
