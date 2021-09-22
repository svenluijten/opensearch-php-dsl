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

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\ReverseNestedAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;

/**
 * @internal
 */
class ReverseNestedAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test for reverse_nested aggregation toArray() method exception.
     */
    public function testToArray(): void
    {
        $termAggregation = new TermsAggregation('acme');

        $aggregation = new ReverseNestedAggregation('test_nested_agg');
        $aggregation->setPath('test_path');
        $aggregation->addAggregation($termAggregation);

        $expectedResult = [
            'reverse_nested' => ['path' => 'test_path'],
            'aggregations' => [
                $termAggregation->getName() => $termAggregation->toArray(),
            ],
        ];

        static::assertEquals($expectedResult, $aggregation->toArray());
    }

    /**
     * Test for reverse_nested aggregation toArray() without path.
     */
    public function testToArrayNoPath(): void
    {
        $termAggregation = new TermsAggregation('acme');

        $aggregation = new ReverseNestedAggregation('test_nested_agg');
        $aggregation->addAggregation($termAggregation);

        $expectedResult = [
            'reverse_nested' => new \stdClass(),
            'aggregations' => [
                $termAggregation->getName() => $termAggregation->toArray(),
            ],
        ];

        static::assertEquals(
            json_encode($expectedResult),
            json_encode($aggregation->toArray())
        );
    }
}
