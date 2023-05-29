<?php

namespace unit\FriendlyDate\Constructor;

use DateTimeImmutable;
use Exception;
use Murolike\Book\FriendlyDate\Constructor\UserFriendlyDateTime;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;
use PHPUnit\Framework\TestCase;
use DateTime;

/**
 * Тестирование основного класса
 */
class UserFriendlyDateTimeTest extends TestCase
{
    /**
     * @var DateTime
     */
    protected DateTime $today;

    /**
     * @var DateTime
     */
    protected DateTime $dayBeforeYesterday;

    /**
     * @var DateTime
     */
    protected DateTime $yesterday;

    /**
     * @var DateTime
     */
    protected DateTime $tomorrow;

    /**
     * @var DateTime
     */
    protected DateTime $dayAfterTomorrow;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->today = new DateTime('today');
        $this->dayBeforeYesterday = new DateTime('yesterday -1 day');
        $this->yesterday = new DateTime('yesterday');
        $this->tomorrow = new DateTime('tomorrow');
        $this->dayAfterTomorrow = new DateTime('tomorrow +1 day');
    }

    /**
     * Тестирование учета таймзоны
     * @return void
     * @throws Exception
     */
    public function testTimezone(): void
    {
        $timeZone = new \DateTimeZone('Europe/Moscow');
        $todayUserDateTime = new DateTime('today midnight');
        $tomorrowUserDateTime = clone $todayUserDateTime;

        $tomorrowUserDateTime->setTime(23, 59);
        $tomorrowUserDateTime->setTimezone($timeZone);
        $todayUserDateTime->setTimezone($timeZone);

        $tomorrowUserFriendlyDateTime = new UserFriendlyDateTime($tomorrowUserDateTime);
        $todayUserFriendlyDateTime = new UserFriendlyDateTime($todayUserDateTime);

        self::assertEquals(UserFriendlyDateTimeText::tomorrow->value, $tomorrowUserFriendlyDateTime->getDate());
        self::assertEquals(UserFriendlyDateTimeText::today->value, $todayUserFriendlyDateTime->getDate());
    }

    /**
     * Тест на текущий день
     * @return void
     * @throws Exception
     */
    public function testIsToday(): void
    {
        $userFriendlyDateTime = new UserFriendlyDateTime($this->today);
        self::assertTrue($userFriendlyDateTime->isToday());

        $userFriendlyDateTime = new UserFriendlyDateTime(new DateTime('tomorrow'));
        self::assertFalse($userFriendlyDateTime->isToday());
    }

    /**
     * Тест на завтра
     * @return void
     * @throws Exception
     */
    public function testIsTomorrow(): void
    {
        $userFriendlyDateTime = new UserFriendlyDateTime($this->tomorrow);
        self::assertTrue($userFriendlyDateTime->isTomorrow());

        $userFriendlyDateTime = new UserFriendlyDateTime(new DateTime());
        self::assertFalse($userFriendlyDateTime->isTomorrow());
    }

    /**
     * Тест на вчера
     * @return void
     * @throws Exception
     */
    public function testIsYesterday(): void
    {
        $userFriendlyDateTime = new UserFriendlyDateTime($this->yesterday);
        self::assertTrue($userFriendlyDateTime->isYesterday());

        $userFriendlyDateTime = new UserFriendlyDateTime(new DateTime());
        self::assertFalse($userFriendlyDateTime->isYesterday());
    }

    /**
     * Тест на послезавтра
     * @return void
     * @throws Exception
     */
    public function testIsDayAfterTomorrow(): void
    {
        $userFriendlyDateTime = new UserFriendlyDateTime($this->dayAfterTomorrow);
        self::assertTrue($userFriendlyDateTime->isDayAfterTomorrow());

        $userFriendlyDateTime = new UserFriendlyDateTime(new DateTime());
        self::assertFalse($userFriendlyDateTime->isDayAfterTomorrow());
    }

    /**
     * Тест на позавчера
     * @return void
     * @throws Exception
     */
    public function testIsDayBeforeYesterday(): void
    {
        $userFriendlyDateTime = new UserFriendlyDateTime($this->dayBeforeYesterday);
        self::assertTrue($userFriendlyDateTime->isDayBeforeYesterday());

        $userFriendlyDateTime = new UserFriendlyDateTime(new DateTime());
        self::assertFalse($userFriendlyDateTime->isDayBeforeYesterday());
    }

    /**
     * Тест на получения текстовой интерпретации
     * @return void
     * @throws Exception
     */
    public function testGetDate(): void
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

    /**
     * Тест на заглавную
     * @return void
     * @throws Exception
     */
    public function testGetCapitalizedDate(): void
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

    /**
     * Преобразование к верхнему регистру
     * @param string $value
     * @return string
     */
    protected function getCapitalizedDate(string $value): string
    {
        return mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }
}
