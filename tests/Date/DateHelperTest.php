<?php

namespace Dpeuscher\Util\Tests\Date;

use Dpeuscher\Util\Date\DateHelper;
use PHPUnit\Framework\TestCase;

/**
 * @category  util
 * @copyright Copyright (c) 2018 Dominik Peuscher
 * @covers \Dpeuscher\Util\Date\DateHelper
 */
class DateHelperTest extends TestCase
{
    /**
     * @var DateHelper
     */
    private $sut;

    /**
     * @var string
     */
    private $format = 'Y-m-d H:i:s.u';
    /**
     * @var string
     */
    private $simpleFormat = 'Y-m-d';

    public function setUp()
    {
        $this->sut = new DateHelper();
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringDottedDateFormat()
    {
        $expected = date('Y') . '-05-03 00:00:00.000000';

        $fromString = '3.5.';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list($fromDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString);

        $this->assertSame($expected, $fromDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringDefaultToDate1MonthInFutureDottedDateFormat()
    {
        $expected = date('Y') . '-06-03 00:00:00.000000';

        $fromString = '3.5.';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringWithToStringDottedDateFormat()
    {
        $expected = date('Y') . '-05-23 00:00:00.000000';

        $fromString = '3.5.';
        $toString = '23.5.';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringWithToStringDefaultDateTimeInterpreterDottedDateFormat()
    {
        $expected = date('Y') . '-05-23 12:30:00.000000';

        $fromString = '3.5.';
        $toString = '23.5.' . date('Y') . ' 12:30:00';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringDashedDateFormat()
    {
        $expected = date('Y') . '-05-03 00:00:00.000000';

        $fromString = '5-3';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list($fromDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString);

        $this->assertSame($expected, $fromDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringDefaultToDate1MonthInFutureDashedDateFormat()
    {
        $expected = date('Y') . '-06-03 00:00:00.000000';

        $fromString = '5-3';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringWithToStringDashedDateFormat()
    {
        $expected = date('Y') . '-05-23 00:00:00.000000';

        $fromString = '5-3';
        $toString = '5-23';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringWithToStringDefaultDateTimeInterpreterDashedDateFormat()
    {
        $expected = date('Y') . '-05-23 12:30:00.000000';

        $fromString = '5-3';
        $toString = '23-5-' . date('Y') . ' 12:30:00';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringWithDottedToStringDefaultDateTimeInterpreterDashedDateFormat()
    {
        $expected = date('Y') . '-05-23 00:00:00.000000';

        $fromString = '5-3';
        $toString = '23.5.';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringPredictedAsMonthDateFormat()
    {
        $expected = date('Y') . '-03-01 00:00:00.000000';

        $fromString = '3';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list($fromDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString);

        $this->assertSame($expected, $fromDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringDefaultToDate1MonthInFuturePredictedDateFormat()
    {
        $tmpDateTime = new \DateTime(date('Y') . '-03-01 00:00:00.000000');
        $tmpDateTime->add(new \DateInterval('P1M'));
        $expected = $tmpDateTime->format($this->format);

        $fromString = '3';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringDefaultToDate1MonthInFutureOverNewYearPredictedDateFormat()
    {
        $tmpDateTime = new \DateTime(date('Y') . '-12-01 00:00:00.000000');
        $tmpDateTime->add(new \DateInterval('P1M'));
        $expected = $tmpDateTime->format($this->format);

        $fromString = '12';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringWithToStringPredictedDateFormat()
    {
        $expected = date('Y') . '-05-01 00:00:00.000000';

        $fromString = '3';
        $toString = '5';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringWithToStringDefaultDateTimeInterpreterPredictedDateFormat()
    {
        $expected = date('Y') . '-' . date('m') . '-23 12:30:00.000000';

        $fromString = '3';
        $toString = '23-' . date('m') . '-' . date('Y') . ' 12:30:00';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringWithDottedToStringDefaultDateTimeInterpreterPredictedDateFormat()
    {
        $expected = date('Y') . '-' . date('m') . '-23 00:00:00.000000';

        $fromString = '3';
        $toString = '23.' . date('m') . '.';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromStringWithDashedToStringDefaultDateTimeInterpreterPredictedDateFormat()
    {
        $expected = date('Y') . '-' . date('m') . '-23 00:00:00.000000';

        $fromString = '3';
        $toString = date('m') . '-23';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromDefaultStringDateFormat()
    {
        $expected = '2018-07-23 12:30:00.000000';

        $fromString = $expected;
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list($fromDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString);

        $this->assertSame($expected, $fromDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromDefaultStringDateFormatDefaultToDate1MonthInFuture()
    {
        $expected = '2018-08-23 12:30:00.000000';

        $fromString = '2018-07-23 12:30:00.000000';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeFromDefaultStringToDefaultStringDateFormat()
    {
        $expected = '2018-08-01 12:30:00.000000';

        $fromString = '2018-07-23 12:30:00.000000';
        $toString = '2018-08-01 12:30:00';
        /**
         * @var \DateTime $fromString
         * @var \DateTime $toString
         */
        list(, $toDate) = $this->sut->buildDateTimeRangeFromTwoInputs($fromString, $toString);

        $this->assertSame($expected, $toDate->format($this->format));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeSince()
    {
        $interval = 'P3D';

        $tmpDateTime = new \DateTime(date('Y') . '-' . date('m') . '-' . date('d') . ' 00:00:00.000000');
        $tmpDateTime->sub(new \DateInterval($interval));
        $expected = $tmpDateTime->format($this->simpleFormat);

        $date = $this->sut->buildDateTimeSince($interval);

        $this->assertSame($expected, $date->format($this->simpleFormat));
    }

    /**
     * @throws \Exception
     */
    public function testBuildDateTimeSinceDefault1DayOnError()
    {
        $interval = 'P1D';

        $tmpDateTime = new \DateTime(date('Y') . '-' . date('m') . '-' . date('d') . ' 00:00:00.000000');
        $tmpDateTime->sub(new \DateInterval($interval));
        $expected = $tmpDateTime->format($this->simpleFormat);

        $date = $this->sut->buildDateTimeSince('INVALID');

        $this->assertSame($expected, $date->format($this->simpleFormat));
    }

    /**
     * @throws \Exception
     */
    public function testDiffToText()
    {
        $interval = new \DateInterval('P3DPT4H5M6S');

        $expected = '3d 4h 5m 6s';

        $intervalString = $this->sut->diffToText($interval);

        $this->assertSame($expected, $intervalString);
    }

    /**
     * @throws \Exception
     */
    public function testDiffToTextWithCalculatedInterval()
    {
        $now = new \DateTime();
        $then = clone $now;
        $now->add(new \DateInterval('P3DPT4H5M6S'));
        $interval = $now->diff($then);

        $expected = '3d 4h 5m 6s';

        $intervalString = $this->sut->diffToText($interval);

        $this->assertSame($expected, $intervalString);
    }

}
