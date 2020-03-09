<?php declare(strict_types=1);

namespace Tests\Model;

use Exception\InvalidArgumentException;
use Exception\RangeException;
use Model\FeeInterpolation;
use Model\FeeInterpolationTable;
use Tests\TestCase;

class FeeInterpolationTableTest extends TestCase
{
    private const TEST_PERIOD = 0;

    public function testUnsorted()
    {
        $table = new FeeInterpolationTable(self::TEST_PERIOD, [
            10 => 10,
            0 => 0,
            100 => 100,
        ]);

        $this->assertEquals(new FeeInterpolation(0, 10, 0, 10), $table->get(5));
        $this->assertEquals(new FeeInterpolation(10, 100, 10, 100), $table->get(50));
    }

    public function testInvalidOptions()
    {
        $this->expectException(InvalidArgumentException::class);
        new FeeInterpolationTable(self::TEST_PERIOD, [
            0 => 0,
        ]);
    }

    public function testRangeUpException(): void
    {
        $calculator = new FeeInterpolationTable(self::TEST_PERIOD, [
            0 => 0,
            100 => 1,
        ]);

        $this->expectException(RangeException::class);
        $calculator->get(101);
    }

    public function testRangeDownException(): void
    {
        $calculator = new FeeInterpolationTable(self::TEST_PERIOD, [
            10 => 0,
            100 => 1,
        ]);

        $this->expectException(RangeException::class);
        $calculator->get(9);
    }
}