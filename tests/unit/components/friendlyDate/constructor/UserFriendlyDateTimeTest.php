<?php

use PHPUnit\Framework\TestCase;
use Murolike\Book\Components\FriendlyDate\UserFriendlyDateTimeText;
use Murolike\Book\Components\FriendlyDate\Constructor\UserFriendlyDateTime;

class UserFriendlyDateTimeTest extends TestCase
{
    protected readonly DateTime $today;
    protected readonly DateTime $dayBeforeYesterday;
    protected readonly DateTime $yesterday;
    protected readonly DateTime $tomorrow;
    protected readonly DateTime $dayAfterTomorrow;

    protected function setUp(): void
    {
        parent::setUp();
        $this->today = new DateTime('today');
        $this->dayBeforeYesterday = new DateTime('yesterday -1 day');
        $this->yesterday = new DateTime('yesterday');
        $this->tomorrow = new DateTime('tomorrow');
        $this->dayAfterTomorrow = new DateTime('tomorrow +1 day');
    }

    public function testIsCurrentDay()
    {
        $component = new UserFriendlyDateTime($this->today);
        self::assertTrue($component->isCurrentDay());

        $component = new UserFriendlyDateTime(new DateTime('tomorrow'));
        self::assertFalse($component->isCurrentDay());
    }

    public function testIsTomorrow()
    {
        $component = new UserFriendlyDateTime($this->tomorrow);
        self::assertTrue($component->isTomorrow());

        $component = new UserFriendlyDateTime(new DateTime());
        self::assertFalse($component->isTomorrow());
    }

    public function testIsYesterday()
    {
        $component = new UserFriendlyDateTime($this->yesterday);
        self::assertTrue($component->isYesterday());

        $component = new UserFriendlyDateTime(new DateTime());
        self::assertFalse($component->isYesterday());
    }

    public function testIsDayAfterTomorrow()
    {
        $component = new UserFriendlyDateTime($this->dayAfterTomorrow);
        self::assertTrue($component->isDayAfterTomorrow());

        $component = new UserFriendlyDateTime(new DateTime());
        self::assertFalse($component->isDayAfterTomorrow());
    }

    public function testIsDayBeforeYesterday()
    {
        $component = new UserFriendlyDateTime($this->dayBeforeYesterday);
        self::assertTrue($component->isDayBeforeYesterday());

        $component = new UserFriendlyDateTime(new DateTime());
        self::assertFalse($component->isDayBeforeYesterday());
    }

    public function testGetDate()
    {
        $currentDayUserFriendlyDateTime = new UserFriendlyDateTime($this->today);
        $tomorrowUserFriendlyDateTime = new UserFriendlyDateTime($this->tomorrow);
        $yesterdayUserFriendlyDateTime = new UserFriendlyDateTime($this->yesterday);
        $dayBeforeYesterdayUserFriendlyDateTime = new UserFriendlyDateTime($this->dayBeforeYesterday);
        $dayAfterTomorrowUserFriendlyDateTime = new UserFriendlyDateTime($this->dayAfterTomorrow);
        $fiveDayAgoUserFriendlyDateTime = new UserFriendlyDateTime(new DateTime('-5 years ago'));

        self::assertEquals(UserFriendlyDateTimeText::today->value, $currentDayUserFriendlyDateTime->getDate());
        self::assertEquals(UserFriendlyDateTimeText::tomorrow->value, $tomorrowUserFriendlyDateTime->getDate());
        self::assertEquals(UserFriendlyDateTimeText::yesterday->value, $yesterdayUserFriendlyDateTime->getDate());
        self::assertEquals(
            UserFriendlyDateTimeText::dayBeforeYesterday->value,
            $dayBeforeYesterdayUserFriendlyDateTime->getDate()
        );
        self::assertEquals(
            UserFriendlyDateTimeText::dayAfterTomorrow->value,
            $dayAfterTomorrowUserFriendlyDateTime->getDate()
        );
        self::assertNull($fiveDayAgoUserFriendlyDateTime->getDate());
    }

    public function testGetCapitalizedDate()
    {
        $currentDayUserFriendlyDateTime = new UserFriendlyDateTime($this->today);
        $tomorrowUserFriendlyDateTime = new UserFriendlyDateTime($this->tomorrow);
        $yesterdayUserFriendlyDateTime = new UserFriendlyDateTime($this->yesterday);
        $dayBeforeYesterdayUserFriendlyDateTime = new UserFriendlyDateTime($this->dayBeforeYesterday);
        $dayAfterTomorrowUserFriendlyDateTime = new UserFriendlyDateTime($this->dayAfterTomorrow);
        $fiveDayAgoUserFriendlyDateTime = new UserFriendlyDateTime(new DateTime('-5 years ago'));

        self::assertEquals(
            $this->getCapitalizedDate(UserFriendlyDateTimeText::today->value),
            $currentDayUserFriendlyDateTime->getCapitalizedDate()
        );
        self::assertEquals(
            $this->getCapitalizedDate(UserFriendlyDateTimeText::tomorrow->value),
            $tomorrowUserFriendlyDateTime->getCapitalizedDate()
        );
        self::assertEquals(
            $this->getCapitalizedDate(UserFriendlyDateTimeText::yesterday->value),
            $yesterdayUserFriendlyDateTime->getCapitalizedDate()
        );
        self::assertEquals(
            $this->getCapitalizedDate(UserFriendlyDateTimeText::dayBeforeYesterday->value),
            $dayBeforeYesterdayUserFriendlyDateTime->getCapitalizedDate()
        );
        self::assertEquals(
            $this->getCapitalizedDate(UserFriendlyDateTimeText::dayAfterTomorrow->value),
            $dayAfterTomorrowUserFriendlyDateTime->getCapitalizedDate()
        );

        self::assertNull($fiveDayAgoUserFriendlyDateTime->getCapitalizedDate());
    }

    protected function getCapitalizedDate($value): string
    {
        return mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }
}
