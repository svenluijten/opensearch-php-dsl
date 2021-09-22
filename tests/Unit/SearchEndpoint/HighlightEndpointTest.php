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

use ONGR\ElasticsearchDSL\Highlight\Highlight;
use ONGR\ElasticsearchDSL\SearchEndpoint\HighlightEndpoint;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class HighlightEndpointTest.
 *
 * @internal
 */
class HighlightEndpointTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf(HighlightEndpoint::class, new HighlightEndpoint());
    }

    /**
     * Tests adding builder.
     */
    public function testNormalization(): void
    {
        $instance = new HighlightEndpoint();
        $normalizerInterface = $this->getMockForAbstractClass(
            NormalizerInterface::class
        );

        $this->assertNull($instance->normalize($normalizerInterface));

        $highlight = new Highlight();
        $highlight->addField('acme');
        $instance->add($highlight);

        $this->assertEquals(
            json_encode($highlight->toArray()),
            json_encode($instance->normalize($normalizerInterface))
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $highlightName = 'acme_highlight';
        $highlight = new Highlight();
        $highlight->addField('acme');

        $endpoint = new HighlightEndpoint();
        $endpoint->add($highlight, $highlightName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($highlight, $builders[$highlightName]);
    }

    public function testItThrowsExceptionOnDuplicateHighlights(): void
    {
        $highlight = new Highlight();

        $endpoint = new HighlightEndpoint();
        $endpoint->add($highlight, 'foo');

        $this->expectException(\OverflowException::class);

        $endpoint->add($highlight, 'bar');
    }
}
