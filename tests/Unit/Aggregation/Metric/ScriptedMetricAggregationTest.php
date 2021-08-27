<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\Metric\ScriptedMetricAggregation;
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
