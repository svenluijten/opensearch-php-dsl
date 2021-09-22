<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Span;

use ONGR\ElasticsearchDSL\Query\Span\SpanFirstQuery;

/**
 * Unit test for SpanFirstQuery.
 *
 * @internal
 */
class SpanFirstQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests for toArray().
     */
    public function testToArray(): void
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\Query\Span\SpanQueryInterface')->getMock();
        $mock
            ->expects(static::once())
            ->method('toArray')
            ->willReturn(['span_term' => ['user' => 'bob']])
        ;

        $query = new SpanFirstQuery($mock, 5);
        $result = [
            'span_first' => [
                'match' => [
                    'span_term' => ['user' => 'bob'],
                ],
                'end' => 5,
            ],
        ];
        static::assertEquals($result, $query->toArray());
    }
}
