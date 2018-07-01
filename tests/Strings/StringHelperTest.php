<?php

namespace Dpeuscher\Util\Tests\Strings;

use Dpeuscher\Util\Strings\StringHelper;
use PHPUnit\Framework\TestCase;

/**
 * @category  util
 * @copyright Copyright (c) 2018 Dominik Peuscher
 * @covers \Dpeuscher\Util\Strings\StringHelper
 */
class StringHelperTest extends TestCase
{
    public function testTrim()
    {
        $text = '0123456789012345678901234567890123456789';
        $expected = '01234567890123456789012345678...';

        $trimmed = StringHelper::trim($text, 32);

        $this->assertSame($expected, $trimmed);
    }
    public function testTrimNoDotsWhenTooShort()
    {
        $text = '01234567890123456789012345678';
        $expected = '01234567890123456789012345678';

        $trimmed = StringHelper::trim($text, 32);

        $this->assertSame($expected, $trimmed);
    }
    public function testTrimNoDotsWhenExactMatch()
    {
        $text = '01234567890123456789012345678901';
        $expected = '01234567890123456789012345678901';

        $trimmed = StringHelper::trim($text, 32);

        $this->assertSame($expected, $trimmed);
    }
    public function testTrimDotsWhen1CharOver()
    {
        $text = '012345678901234567890123456789012';
        $expected = '01234567890123456789012345678...';

        $trimmed = StringHelper::trim($text, 32);

        $this->assertSame($expected, $trimmed);
    }
    public function testShortenName()
    {
        $name = 'John Doe';
        $expected = 'John D';

        $shortened = StringHelper::shortenNameToFirst($name);

        $this->assertSame($expected, $shortened);
    }
    public function testShortenNameWithMiddleName()
    {
        $name = 'John F Doe';
        $expected = 'John D';

        $shortened = StringHelper::shortenNameToFirst($name);

        $this->assertSame($expected, $shortened);
    }
    public function testShortenNameWithOnlyOneName()
    {
        $name = 'John';
        $expected = 'John';

        $shortened = StringHelper::shortenNameToFirst($name);

        $this->assertSame($expected, $shortened);
    }
}
