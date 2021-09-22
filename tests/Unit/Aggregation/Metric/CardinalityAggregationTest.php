<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\Metric\CardinalityAggregation;

/**
 * Unit test for cardinality aggregation.
 *
 * @internal
 */
class CardinalityAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests getArray method.
     */
    public function testGetArray(): void
    {
        $aggregation = new CardinalityAggregation('bar');

        $aggregation->setScript('foo');
        $result = $aggregation->getArray();

        static::assertArrayHasKey('script', $result, 'key=script when script is set');
        static::assertEquals('foo', $result['script'], 'script=foo when scripts name=foo');

        $aggregation->setField('foo');
        $result = $aggregation->getArray();

        static::assertArrayHasKey('field', $result, 'key=field when field is set');
        static::assertEquals('foo', $result['field'], 'field=foo when fields name=foo');

        $aggregation->setPrecisionThreshold(10);
        $result = $aggregation->getArray();

        static::assertArrayHasKey('precision_threshold', $result, 'key=precision_threshold when is set');
        static::assertEquals(10, $result['precision_threshold'], 'precision_threshold=10 when is set');

        $aggregation->setRehash(true);
        $result = $aggregation->getArray();

        static::assertArrayHasKey('rehash', $result, 'key=rehash when rehash is set');
        static::assertTrue($result['rehash'], 'rehash=true when rehash is set to true');
    }

    /**
     * Tests getType method.
     */
    public function testCardinallyAggregationGetType(): void
    {
        $aggregation = new CardinalityAggregation('foo');
        $result = $aggregation->getType();
        static::assertEquals('cardinality', $result);
    }
}
