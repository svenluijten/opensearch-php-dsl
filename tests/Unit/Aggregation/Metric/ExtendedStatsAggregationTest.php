<?php

namespace OpenSearchDSL\Tests\Unit\Aggregation\Metric;

use OpenSearchDSL\Aggregation\Metric\ExtendedStatsAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ExtendedStatsAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new ExtendedStatsAggregation('test', 'test', 5, 'script');
        static::assertSame([
            'extended_stats' => [
                'field' => 'test',
                'script' => 'script',
                'sigma' => 5,
            ],
        ], $a->toArray());
    }
}
