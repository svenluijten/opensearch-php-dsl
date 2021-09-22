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

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;
use ONGR\ElasticsearchDSL\Highlight\Highlight;
use ONGR\ElasticsearchDSL\InnerHit\NestedInnerHit;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermsQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Serializer\OrderedSerializer;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use ONGR\ElasticsearchDSL\Suggest\Suggest;

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
        static::assertInstanceOf('ONGR\ElasticsearchDSL\Search', new Search());
    }

    public function testScrollUriParameter(): void
    {
        $search = new Search();
        $search->setScroll('5m');
        $search->__wakeup();

        static::assertArrayHasKey('scroll', $search->getUriParams());
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

    public function testInitializeSerializer(): void
    {
        $search = new \ReflectionClass(Search::class);
        $search->setStaticPropertyValue('serializer', null);

        new Search();

        static::assertInstanceOf(OrderedSerializer::class, $search->getStaticPropertyValue('serializer'));
    }

    public function testToArray(): void
    {
        $search = new Search();
        $search->setSize(5);

        $search->toArray();

        static::assertSame(
            [
                'size' => 5,
            ],
            $search->toArray(),
        );
    }

    public function testAdders(): void
    {
        $search = new Search();

        $search->addAggregation(new TermsAggregation('acme'));
        $search->addQuery(new MatchAllQuery(), BoolQuery::MUST, 'foo');
        $search->addInnerHit(new NestedInnerHit('foo', 'foo'));
        $search->addPostFilter(new TermsQuery('foo', ['bar']), BoolQuery::MUST, 'foo');
        $search->addSort(new FieldSort('foo'));
        $search->addSuggest(new Suggest('foo', 'suggest', 'foo_bar', 'bar'));
        $search->addHighlight(new Highlight());
        $search->addUriParam('timeout', 'bar');

        static::assertInstanceOf(TermsAggregation::class, $search->getAggregations()['acme']);
        static::assertInstanceOf(MatchAllQuery::class, $search->getQueries()->getQueries(BoolQuery::MUST)['foo']);
        static::assertInstanceOf(NestedInnerHit::class, $search->getInnerHits()['foo']);
        static::assertInstanceOf(TermsQuery::class, $search->getPostFilters()->getQueries(BoolQuery::MUST)['foo']);
        static::assertInstanceOf(FieldSort::class, \array_values($search->getSorts())[0]);
        static::assertInstanceOf(Suggest::class, \array_values($search->getSuggests())[0]);
        static::assertInstanceOf(Highlight::class, $search->getHighlights());
        static::assertSame('bar', $search->getUriParams()['timeout']);
    }

    public function testGetters(): void
    {
        $search = new Search();

        $search->setDocValueFields([]);
        $search->setFrom(5);
        $search->setTrackTotalHits(true);
        $search->setSize(10);
        $search->setSource(true);
        $search->setStoredFields([]);
        $search->setScriptFields([]);
        $search->setExplain(true);
        $search->setVersion(true);
        $search->setIndicesBoost([]);
        $search->setMinScore(7);
        $search->setSearchAfter([]);
        $search->setScroll([]);

        static::assertSame([], $search->getDocValueFields());
        static::assertSame(5, $search->getFrom());
        static::assertTrue($search->isTrackTotalHits());
        static::assertSame(10, $search->getSize());
        static::assertTrue($search->isSource());
        static::assertTrue($search->getSource());
        static::assertSame([], $search->getStoredFields());
        static::assertSame([], $search->getScriptFields());
        static::assertTrue($search->isExplain());
        static::assertTrue($search->isVersion());
        static::assertSame([], $search->getIndicesBoost());
        static::assertSame(7, $search->getMinScore());
        static::assertSame([], $search->getSearchAfter());
        static::assertSame([], $search->getScroll());
    }
}
