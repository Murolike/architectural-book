<?php

namespace unit\FriendlyDate\Constructor;

use DateTime;
use Exception;
use Murolike\Book\FriendlyDate\Constructor\TwoWeeksUserFriendlyDateTime;
use Murolike\Book\FriendlyDate\UserFriendlyDateTimeText;
use PHPUnit\Framework\TestCase;

class UserFriendlyDateTimeExtendedByInheritTest extends TestCase
{
    /**
     * @var DateTime
     */
    protected DateTime $twoWeeksAgo;

    /**
     * @var DateTime
     */
    protected DateTime $twoWeeksLater;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->twoWeeksAgo = new DateTime('-2 weeks midnight');
        $this->twoWeeksLater = new DateTime('+2 weeks midnight');
    }

    /**
     * Тест на получение текстовой интерпретации
     * @return void
     * @throws Exception
     */
    public function testGetDate()
    {
        $twoWeeksAgoUserFriendlyDateTime = new TwoWeeksUserFriendlyDateTime($this->twoWeeksAgo);
        $twoWeeksLaterUserFriendlyDateTime = new TwoWeeksUserFriendlyDateTime($this->twoWeeksLater);

        self::assertEquals(UserFriendlyDateTimeText::twoWeekAgo->value, $twoWeeksAgoUserFriendlyDateTime->getDate());
        self::assertEquals(
            UserFriendlyDateTimeText::twoWeekLater->value,
            $twoWeeksLaterUserFriendlyDateTime->getDate()
        );
    }

    /**
     * Тест на получение текста с заглавной
     * @return void
     * @throws Exception
     */
    public function testGetCapitalizedDate()
    {
        $twoWeeksAgoUserFriendlyDateTime = new TwoWeeksUserFriendlyDateTime($this->twoWeeksAgo);
        $twoWeeksLaterUserFriendlyDateTime = new TwoWeeksUserFriendlyDateTime($this->twoWeeksLater);

        self::assertEquals(
            $this->getCapitalizedDate(UserFriendlyDateTimeText::twoWeekAgo->value),
            $twoWeeksAgoUserFriendlyDateTime->getCapitalizedDate()
        );
        self::assertEquals(
            $this->getCapitalizedDate(UserFriendlyDateTimeText::twoWeekLater->value),
            $twoWeeksLaterUserFriendlyDateTime->getCapitalizedDate()
        );
    }

    /**
     * Тест на две недели ранее
     * @return void
     * @throws Exception
     */
    public function testIsTwoWeeksLater()
    {
        $userFriendlyDateTime = new TwoWeeksUserFriendlyDateTime($this->twoWeeksLater);
        self::assertTrue($userFriendlyDateTime->isTwoWeeksLater());

        $userFriendlyDateTime = new TwoWeeksUserFriendlyDateTime(new DateTime('tomorrow'));
        self::assertFalse($userFriendlyDateTime->isTwoWeeksLater());
    }

    /**
     * Тест на две недели позднее
     * @return void
     * @throws Exception
     */
    public function testIsTwoWeeksAgo()
    {
        $userFriendlyDateTime = new TwoWeeksUserFriendlyDateTime($this->twoWeeksAgo);
        self::assertTrue($userFriendlyDateTime->isTwoWeeksAgo());

        $userFriendlyDateTime = new TwoWeeksUserFriendlyDateTime(new DateTime('tomorrow'));
        self::assertFalse($userFriendlyDateTime->isTwoWeeksAgo());
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
