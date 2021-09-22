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

use ONGR\ElasticsearchDSL\Aggregation\Metric\GeoBoundsAggregation;

/**
 * Unit test for geo bounds aggregation.
 *
 * @internal
 */
class GeoBoundsAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests getType method.
     */
    public function testGeoBoundsAggregationGetType(): void
    {
        $agg = new GeoBoundsAggregation('foo', '');
        $result = $agg->getType();
        static::assertEquals('geo_bounds', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testGeoBoundsAggregationGetArray(): void
    {
        $agg = new GeoBoundsAggregation('foo', '');
        $agg->setField('bar');
        $agg->setWrapLongitude(true);
        $result = [
            'geo_bounds' => [
                'field' => 'bar',
                'wrap_longitude' => true,
            ],
        ];
        static::assertEquals($result, $agg->toArray(), 'when wraplongitude is true');

        $agg->setWrapLongitude(false);
        $result = [
            'geo_bounds' => [
                'field' => 'bar',
                'wrap_longitude' => false,
            ],
        ];
        static::assertEquals($result, $agg->toArray(), 'when wraplongitude is false');
    }
}
