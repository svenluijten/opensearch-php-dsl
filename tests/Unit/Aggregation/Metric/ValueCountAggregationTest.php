<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\Metric\MaxAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Metric\SumAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Metric\ValueCountAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ValueCountAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new ValueCountAggregation('test', 'test');
        static::assertSame([
            'value_count' => [
                'field' => 'test',
            ],
        ], $a->toArray());
    }
}
