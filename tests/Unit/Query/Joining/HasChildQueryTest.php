<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Joining;

use ONGR\ElasticsearchDSL\Query\Joining\HasChildQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermsQuery;

/**
 * @internal
 */
class HasChildQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests whether __constructor calls setParameters method.
     */
    public function testConstructor(): void
    {
        $parentQuery = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
        $query = new HasChildQuery('test_type', $parentQuery, ['test_parameter1']);
        static::assertEquals(['test_parameter1'], $query->getParameters());
    }

    public function testToArray(): void
    {
        $query = new TermsQuery('foo', ['bar']);
        $parentQuery = new HasChildQuery('type', $query, ['foo' => 'bar']);

        static::assertSame(
            [
                'has_child' => [
                    'type' => 'type',
                    'query' => [
                        'terms' => [
                            'foo' => ['bar'],
                        ],
                    ],
                    'foo' => 'bar',
                ],
            ],
            $parentQuery->toArray(),
        );
    }
}
