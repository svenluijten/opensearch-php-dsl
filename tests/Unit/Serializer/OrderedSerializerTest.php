<?php declare(strict_types=1);

namespace OpenSearchDSL\Tests\Unit\Serializer;

use OpenSearchDSL\Query\MatchAllQuery;
use OpenSearchDSL\Query\TermLevel\TermsQuery;
use OpenSearchDSL\Search;
use OpenSearchDSL\SearchEndpoint\PostFilterEndpoint;
use OpenSearchDSL\SearchEndpoint\QueryEndpoint;
use OpenSearchDSL\Serializer\OrderedSerializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;

/**
 * @internal
 */
class OrderedSerializerTest extends TestCase
{
    public function testOrdering(): void
    {
        $serializer = new OrderedSerializer([
            new CustomNormalizer(),
        ]);

        $search = new Search();
        $search->addQuery(new MatchAllQuery());
        $search->addPostFilter(new TermsQuery('foo', ['bar']));

        static::assertEquals(
            [
                [
                    'terms' => [
                        'foo' => ['bar'],
                    ],
                ],
                [
                    'match_all' => new \stdClass(),
                ],
            ],
            $serializer->normalize(
                [
                    $search->getEndpoint(QueryEndpoint::NAME),
                    $search->getEndpoint(PostFilterEndpoint::NAME),
                ]
            )
        );
    }

    public function testDenormalizeThrowsExceptions(): void
    {
        $serializer = new OrderedSerializer();

        $this->expectException(\BadFunctionCallException::class);

        $serializer->denormalize(['foo'], 'test');
    }
}
