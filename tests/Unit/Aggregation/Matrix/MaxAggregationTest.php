<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Matrix;

use ONGR\ElasticsearchDSL\Aggregation\Matrix\MaxAggregation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class MaxAggregationTest extends TestCase
{
    public function testConstructor(): void
    {
        $a = new MaxAggregation('test', 'test', ['test'], 'test');
        static::assertSame(['test'], $a->getMissing());
        static::assertSame(['test'], $a->getFields());
        static::assertSame([
            'matrix_stats' => [
                'fields' => null,
                'mode' => 'test',
                'missing' => ['test'],
            ],
        ], $a->toArray());
    }
}
