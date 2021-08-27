<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\Ipv4RangeAggregation;

/**
 * @internal
 */
class Ipv4RangeAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests if field and range  can be passed to constructor.
     */
    public function testConstructorFilter(): void
    {
        $aggregation = new Ipv4RangeAggregation('test', 'fieldName', [['from' => 'fromValue']]);
        $this->assertSame(
            [
                'ip_range' => [
                    'field' => 'fieldName',
                    'ranges' => [['from' => 'fromValue']],
                ],
            ],
            $aggregation->toArray()
        );

        $aggregation = new Ipv4RangeAggregation('test', 'fieldName', ['maskValue']);
        $this->assertSame(
            [
                'ip_range' => [
                    'field' => 'fieldName',
                    'ranges' => [['mask' => 'maskValue']],
                ],
            ],
            $aggregation->toArray()
        );
    }

    public function testWithoutRanges(): void
    {
        static::expectException(\LogicException::class);
        $aggregation = new Ipv4RangeAggregation('test', 'fieldName');
        $aggregation->toArray();
    }
}
