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

use ONGR\ElasticsearchDSL\Aggregation\Metric\GeoCentroidAggregation;

/**
 * Unit test for children aggregation.
 *
 * @internal
 */
class GeoCentroidAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests getType method.
     */
    public function testGeoCentroidAggregationGetType(): void
    {
        $aggregation = new GeoCentroidAggregation('foo', '');
        $this->assertEquals('geo_centroid', $aggregation->getType());
    }

    /**
     * Tests getArray method.
     */
    public function testGeoCentroidAggregationGetArray(): void
    {
        $aggregation = new GeoCentroidAggregation('foo', 'location');
        $this->assertEquals(['field' => 'location'], $aggregation->getArray());
    }
}
