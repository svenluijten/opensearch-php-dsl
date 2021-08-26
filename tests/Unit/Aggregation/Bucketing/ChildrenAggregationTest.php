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

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\ChildrenAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;

/**
 * Unit test for children aggregation.
 *
 * @internal
 */
class ChildrenAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests if ChildrenAggregation#getArray throws exception when expected.
     */
    public function testGetArrayException(): void
    {
        $this->expectException(\LogicException::class);
        $aggregation = new ChildrenAggregation('foo');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testChildrenAggregationGetType(): void
    {
        $aggregation = new ChildrenAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('children', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testChildrenAggregationGetArray(): void
    {
        $aggregation = new ChildrenAggregation('foo');
        $aggregation->setChildren('question');
        $aggregation->addAggregation(new TermsAggregation('test'));
        $result = $aggregation->getArray();
        $expected = ['type' => 'question'];
        $this->assertEquals($expected, $result);
    }
}
