<?php

namespace OpenSearchDSL\Tests\Unit\Aggregation\Metric;

use OpenSearchDSL\Aggregation\Metric\ScriptedMetricAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ScriptedMetricAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new ScriptedMetricAggregation('test', 'init', 'map', 'combine', 'reduce');
        static::assertSame([
            'scripted_metric' => [
                'init_script' => 'init',
                'map_script' => 'map',
                'combine_script' => 'combine',
                'reduce_script' => 'reduce',
            ],
        ], $a->toArray());
    }
}
