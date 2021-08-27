<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit;

use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Search;

/**
 * Test for Search.
 *
 * @internal
 */
class SearchTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests Search constructor.
     */
    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\Search', new Search());
    }

    public function testScrollUriParameter(): void
    {
        $search = new Search();
        $search->setScroll('5m');
        $search->__wakeup();

        $this->assertArrayHasKey('scroll', $search->getUriParams());
    }

    public function testInvalidParameter(): void
    {
        static::expectException(\InvalidArgumentException::class);

        $search = new Search();
        $search->addUriParam('test', 'test');
    }

    public function testEndpointDestroy(): void
    {
        $search = new Search();
        $search->addQuery(new MatchAllQuery());
        static::assertArrayHasKey('query', $search->toArray());
        $search->destroyEndpoint('query');
        static::assertArrayNotHasKey('query', $search->toArray());
    }

    public function testPostFilter(): void
    {
        $search = new Search();
        $search->addPostFilter(new MatchAllQuery());
        static::assertArrayHasKey('post_filter', $search->toArray());

        static::assertInstanceOf(BoolQuery::class, $search->getPostFilters());
    }
}
