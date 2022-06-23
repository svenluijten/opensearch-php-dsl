<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Aggregation\Bucketing;

use OpenSearchDSL\Aggregation\Bucketing\DateHistogramAggregation;

/**
 * Unit test for children aggregation.
 *
 * @internal
 */
class DateHistogramAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests getType method.
     */
    public function testDateHistogramAggregationGetType(): void
    {
        $aggregation = new DateHistogramAggregation('foo', 'test');
        $result = $aggregation->getType();
        static::assertEquals('date_histogram', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testChildrenAggregationGetArray(): void
    {
        $aggregation = new DateHistogramAggregation('foo', 'test');
        $aggregation->setField('date');
        $aggregation->setCalendarInterval('month');
        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'calender_interval' => 'month'];
        static::assertEquals($expected, $result);
    }

    public function testWithoutInterval(): void
    {
        static::expectException(\LogicException::class);
        (new DateHistogramAggregation('foo', 'test'))->toArray();
    }

    public function testTimeZoneWillBePassed(): void
    {
        $aggregation = new DateHistogramAggregation('foo', 'test');
        $aggregation->setTimeZone('Europe/Berlin');
        $aggregation->setCalendarInterval('1m');
        $aggregation->setFixedInterval('1m');
        $aggregation->setFormat('YYYY-mm-dd');

        static::assertSame([
            'date_histogram' => [
                'field' => 'test',
                'calender_interval' => '1m',
                'fixed_interval' => '1m',
                'time_zone' => 'Europe/Berlin',
                'format' => 'YYYY-mm-dd',
            ],
        ], $aggregation->toArray());
    }
}
