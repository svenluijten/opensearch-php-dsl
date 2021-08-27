<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\Metric\MinAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class MinAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new MinAggregation('test', 'test');
        static::assertSame([
            'min' => [
                'field' => 'test',
            ],
        ], $a->toArray());
    }
}
