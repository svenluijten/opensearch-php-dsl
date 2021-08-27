<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\Metric\SumAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class SumAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new SumAggregation('test', 'test');
        static::assertSame([
            'sum' => [
                'field' => 'test',
            ],
        ], $a->toArray());
    }
}
