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

        $this->assertArrayHasKey('scroll', $search->getUriParams());
    }
}
