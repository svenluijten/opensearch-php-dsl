<?php declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Tests\Unit\Serializer;

use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermsQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\SearchEndpoint\PostFilterEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\QueryEndpoint;
use ONGR\ElasticsearchDSL\Serializer\Normalizer\CustomReferencedNormalizer;
use ONGR\ElasticsearchDSL\Serializer\OrderedSerializer;
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
            new CustomReferencedNormalizer(),
            new CustomNormalizer(),
        ]);

        $search = new Search();
        $search->addQuery(new MatchAllQuery());
        $search->addPostFilter(new TermsQuery('foo', ['bar']));

        $this->assertEquals(
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
