<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;

/**
 * Unit test for children aggregation.
 *
 * @internal
 */
class DateHistogramAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests if ChildrenAggregation#getArray throws exception when expected.
     */
    public function testGetArrayException(): void
    {
        $this->expectException(\LogicException::class);
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testDateHistogramAggregationGetType(): void
    {
        $aggregation = new DateHistogramAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('date_histogram', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testChildrenAggregationGetArray(): void
    {
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->setField('date');
        $aggregation->setInterval('month');
        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'interval' => 'month'];
        $this->assertEquals($expected, $result);
    }
}
