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

use ONGR\ElasticsearchDSL\SearchEndpoint\InnerHitsEndpoint;

/**
 * Class AggregationsEndpointTest.
 *
 * @internal
 */
class InnerHitsEndpointTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated(): void
    {
        static::assertInstanceOf(
            'ONGR\ElasticsearchDSL\SearchEndpoint\InnerHitsEndpoint',
            new InnerHitsEndpoint()
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $hitName = 'foo';
        $innerHit = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
        $endpoint = new InnerHitsEndpoint();
        $endpoint->add($innerHit, $hitName);
        $builders = $endpoint->getAll();

        static::assertCount(1, $builders);
        static::assertSame($innerHit, $builders[$hitName]);
    }

    /**
     * Tests normalize method
     */
    public function testNormalization(): void
    {
        $normalizer = $this
            ->getMockBuilder('Symfony\Component\Serializer\Normalizer\NormalizerInterface')
            ->getMock()
        ;
        $innerHit = $this
            ->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')
            ->onlyMethods(['toArray', 'getType'])
            ->addMethods(['getName'])
            ->getMock()
        ;
        $innerHit->expects(static::any())->method('getName')->willReturn('foo');
        $innerHit->expects(static::any())->method('toArray')->willReturn(['foo' => 'bar']);

        $endpoint = new InnerHitsEndpoint();
        $endpoint->add($innerHit, 'foo');
        $expected = [
            'foo' => [
                'foo' => 'bar',
            ],
        ];

        static::assertEquals(
            $expected,
            $endpoint->normalize($normalizer)
        );
    }
}
