<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\Metric\AvgAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class AvgAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new AvgAggregation('test', 'test');

        static::assertSame([
            'avg' => [
                'field' => 'test',
            ],
        ], $a->toArray());
    }
}
