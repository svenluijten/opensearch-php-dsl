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

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\MissingAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;
use ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;

/**
 * Class AggregationsEndpointTest.
 *
 * @internal
 */
class AggregationsEndpointTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated(): void
    {
        static::assertInstanceOf(
            'ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint',
            new AggregationsEndpoint()
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $aggName = 'acme_agg';
        $agg = new MissingAggregation('acme', '');
        $endpoint = new AggregationsEndpoint();
        $endpoint->add($agg, $aggName);
        $builders = $endpoint->getAll();

        static::assertCount(1, $builders);
        static::assertSame($agg, $builders[$aggName]);
    }

    public function testNormalize(): void
    {
        $agg1 = new MissingAggregation('bar', '');
        $agg2 = new TermsAggregation('foo');
        $endpoint = new AggregationsEndpoint();
        $endpoint->add($agg1, 'bar');
        $endpoint->add($agg2, 'foo');

        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );

        static::assertSame(
            [
                'bar' => [
                    'missing' => [
                        'field' => '',
                    ],
                ],
                'foo' => [
                    'terms' => [],
                ],
            ],
            $endpoint->normalize($normalizerInterface)
        );
    }
}
