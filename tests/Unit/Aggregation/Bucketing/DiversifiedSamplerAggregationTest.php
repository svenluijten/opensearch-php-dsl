<?php

namespace OpenSearchDSL\Tests\Unit\Aggregation\Bucketing;

use OpenSearchDSL\Aggregation\Bucketing\DiversifiedSamplerAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DiversifiedSamplerAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new DiversifiedSamplerAggregation('test', 'test', 5);
        static::assertSame(5, $a->getShardSize());

        static::assertSame([
            'diversified_sampler' => [
                'field' => 'test',
                'shard_size' => 5,
            ],
        ], $a->toArray());
    }
}
