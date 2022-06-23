<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Aggregation\Bucketing;

use OpenSearchDSL\Aggregation\Bucketing\GeoHashGridAggregation;

/**
 * Unit test for geohash grid aggregation.
 *
 * @internal
 */
class GeoHashGridAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data provider for testGeoHashGridAggregationGetArray().
     *
     * @return array
     */
    public function getArrayDataProvider()
    {
        $out = [];

        $filterData = [
            'field' => 'location',
            'precision' => 3,
            'size' => 10,
            'shard_size' => 10,
        ];

        $expectedResults = [
            'field' => 'location',
            'precision' => 3,
            'size' => 10,
            'shard_size' => 10,
        ];

        $out[] = [$filterData, $expectedResults];

        return $out;
    }

    /**
     * Tests getArray method.
     *
     * @param array $filterData
     * @param array $expected
     *
     * @dataProvider getArrayDataProvider
     */
    public function testGeoHashGridAggregationGetArray($filterData, $expected): void
    {
        $aggregation = new GeoHashGridAggregation('foo', '');
        $aggregation->setPrecision($filterData['precision']);
        $aggregation->setSize($filterData['size']);
        $aggregation->setShardSize($filterData['shard_size']);
        $aggregation->setField($filterData['field']);

        $result = $aggregation->getArray();
        static::assertEquals($result, $expected);
    }

    /**
     * Tests getType method.
     */
    public function testGeoHashGridAggregationGetType(): void
    {
        $aggregation = new GeoHashGridAggregation('foo', '');
        $result = $aggregation->getType();
        static::assertEquals('geohash_grid', $result);
    }
}
