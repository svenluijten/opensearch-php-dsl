<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\SearchEndpoint\PostFilterEndpoint;

/**
 * Class PostFilterEndpointTest.
 *
 * @internal
 */
class PostFilterEndpointTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated(): void
    {
        static::assertInstanceOf('ONGR\ElasticsearchDSL\SearchEndpoint\PostFilterEndpoint', new PostFilterEndpoint());
    }

    /**
     * Tests if correct order is returned. It's very important that filters must be executed second.
     */
    public function testGetOrder(): void
    {
        $instance = new PostFilterEndpoint();
        static::assertEquals(1, $instance->getOrder());
    }

    /**
     * Test normalization.
     */
    public function testNormalization(): void
    {
        $instance = new PostFilterEndpoint();
        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );
        static::assertNull($instance->normalize($normalizerInterface));

        $matchAll = new MatchAllQuery();
        $instance->add($matchAll);

        static::assertEquals(
            json_encode($matchAll->toArray()),
            json_encode($instance->normalize($normalizerInterface))
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $filterName = 'acme_post_filter';
        $filter = new MatchAllQuery();

        $endpoint = new PostFilterEndpoint();
        $endpoint->add($filter, $filterName);
        $builders = $endpoint->getAll();

        static::assertCount(1, $builders);
        static::assertSame($filter, $builders[$filterName]);
    }
}
