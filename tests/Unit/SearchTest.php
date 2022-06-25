<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit;

use OpenSearchDSL\Aggregation\Bucketing\TermsAggregation;
use OpenSearchDSL\Highlight\Highlight;
use OpenSearchDSL\InnerHit\NestedInnerHit;
use OpenSearchDSL\Query\Compound\BoolQuery;
use OpenSearchDSL\Query\MatchAllQuery;
use OpenSearchDSL\Query\TermLevel\TermsQuery;
use OpenSearchDSL\Search;
use OpenSearchDSL\Serializer\OrderedSerializer;
use OpenSearchDSL\Sort\FieldSort;
use OpenSearchDSL\Suggest\Suggest;

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
        static::assertInstanceOf('OpenSearchDSL\Search', new Search());
    }

    public function testScrollUriParameter(): void
    {
        $search = new Search();
        $reflection = new \ReflectionClass($search);
        $reflection->setStaticPropertyValue('serializer', null);

        $search->setScroll('5m');
        $search->__wakeup();

        $val = $reflection->getStaticPropertyValue('serializer');
        static::assertNotEmpty($val);

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

        static::assertSame($search, $search->addAggregation(new TermsAggregation('acme')));
        static::assertSame($search, $search->addQuery(new MatchAllQuery(), BoolQuery::MUST, 'foo'));
        static::assertSame($search, $search->addInnerHit(new NestedInnerHit('foo', 'foo')));
        static::assertSame($search, $search->addPostFilter(new TermsQuery('foo', ['bar']), BoolQuery::MUST, 'foo'));
        static::assertSame($search, $search->addSort(new FieldSort('foo')));
        static::assertSame($search, $search->addSuggest(new Suggest('foo', 'suggest', 'foo_bar', 'bar')));
        static::assertSame($search, $search->addHighlight(new Highlight()));
        static::assertSame($search, $search->addUriParam('timeout', 'bar'));

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

        static::assertSame($search, $search->setDocValueFields([]));
        static::assertSame($search, $search->setFrom(5));
        static::assertSame($search, $search->setTrackTotalHits(true));
        static::assertSame($search, $search->setSize(10));
        static::assertSame($search, $search->setSource(true));
        static::assertSame($search, $search->setStoredFields([]));
        static::assertSame($search, $search->setScriptFields([]));
        static::assertSame($search, $search->setExplain(true));
        static::assertSame($search, $search->setVersion(true));
        static::assertSame($search, $search->setIndicesBoost([]));
        static::assertSame($search, $search->setMinScore(7));
        static::assertSame($search, $search->setSearchAfter([]));
        static::assertSame($search, $search->setScroll([]));

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
