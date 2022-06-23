<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\Tests\Unit\Query\Span;

use OpenSearchDSL\Query\Span\SpanMultiTermQuery;

/**
 * Unit test for SpanMultiTermQuery.
 *
 * @internal
 */
class SpanMultiTermQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test for toArray().
     */
    public function testToArray(): void
    {
        $mock = $this->getMockBuilder('OpenSearchDSL\BuilderInterface')->getMock();
        $mock
            ->expects(static::once())
            ->method('toArray')
            ->willReturn(['prefix' => ['user' => ['value' => 'ki']]])
        ;

        $query = new SpanMultiTermQuery($mock);
        $expected = [
            'span_multi' => [
                'match' => [
                    'prefix' => ['user' => ['value' => 'ki']],
                ],
            ],
        ];

        static::assertEquals($expected, $query->toArray());
    }
}
