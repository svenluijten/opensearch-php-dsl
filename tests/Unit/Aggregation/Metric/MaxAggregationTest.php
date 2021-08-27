<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\Metric\MaxAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class MaxAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new MaxAggregation('test', 'test');
        static::assertSame([
            'max' => [
                'field' => 'test',
            ],
        ], $a->toArray());
    }
}
