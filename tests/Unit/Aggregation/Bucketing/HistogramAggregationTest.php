<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\HistogramAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class HistogramAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new HistogramAggregation(
            'test',
            'test',
            5,
            2,
            'test',
            HistogramAggregation::DIRECTION_ASC,
            5,
            6,
            false
        );

        static::assertSame(['test' => HistogramAggregation::DIRECTION_ASC], $a->getOrder());
        static::assertSame(['min' => 5, 'max' => 6], $a->getExtendedBounds());
        static::assertFalse($a->isKeyed());
    }
}
