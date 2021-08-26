<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Geo;

use ONGR\ElasticsearchDSL\Query\Geo\GeoBoundingBoxQuery;

/**
 * @internal
 */
class GeoBoundingBoxQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test if exception is thrown when geo points are not set.
     */
    public function testGeoBoundBoxQueryException(): void
    {
        $this->expectException(\LogicException::class);
        $query = new GeoBoundingBoxQuery('location', []);
        $query->toArray();
    }

    /**
     * Data provider for testToArray().
     *
     * @return array
     */
    public function getArrayDataProvider()
    {
        return [
            // Case #1 (2 values).
            [
                'location',
                [
                    ['lat' => 40.73, 'lon' => -74.1],
                    ['lat' => 40.01, 'lon' => -71.12],
                ],
                ['parameter' => 'value'],
                [
                    'location' => [
                        'top_left' => ['lat' => 40.73, 'lon' => -74.1],
                        'bottom_right' => ['lat' => 40.01, 'lon' => -71.12],
                    ],
                    'parameter' => 'value',
                ],
            ],
            // Case #2 (2 values with keys).
            [
                'location',
                [
                    'bottom_right' => ['lat' => 40.01, 'lon' => -71.12],
                    'top_left' => ['lat' => 40.73, 'lon' => -74.1],
                ],
                ['parameter' => 'value'],
                [
                    'location' => [
                        'top_left' => ['lat' => 40.73, 'lon' => -74.1],
                        'bottom_right' => ['lat' => 40.01, 'lon' => -71.12],
                    ],
                    'parameter' => 'value',
                ],
            ],
            // Case #2 (4 values).
            [
                'location',
                [40.73, -74.1, 40.01, -71.12],
                ['parameter' => 'value'],
                [
                    'location' => [
                        'top' => 40.73,
                        'left' => -74.1,
                        'bottom' => 40.01,
                        'right' => -71.12,
                    ],
                    'parameter' => 'value',
                ],
            ],
            // Case #3 (4 values with keys).
            [
                'location',
                [
                    // out of order
                    'right' => -71.12,
                    'bottom' => 40.01,
                    'top' => 40.73,
                    'left' => -74.1,
                ],
                ['parameter' => 'value'],
                [
                    'location' => [
                        'top' => 40.73,
                        'left' => -74.1,
                        'bottom' => 40.01,
                        'right' => -71.12,
                    ],
                    'parameter' => 'value',
                ],
            ],
        ];
    }

    /**
     * Tests toArray method.
     *
     * @param string $field field name
     * @param array $values bounding box values
     * @param array $parameters optional parameters
     * @param array $expected expected result
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($field, $values, $parameters, $expected): void
    {
        $query = new GeoBoundingBoxQuery($field, $values, $parameters);
        $result = $query->toArray();
        $this->assertEquals(['geo_bounding_box' => $expected], $result);
    }
}
