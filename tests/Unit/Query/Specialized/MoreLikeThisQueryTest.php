<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Specialized;

use ONGR\ElasticsearchDSL\Query\Specialized\MoreLikeThisQuery;

/**
 * @internal
 */
class MoreLikeThisQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new MoreLikeThisQuery('this is a test', ['fields' => ['title', 'description']]);
        $expected = [
            'more_like_this' => [
                'fields' => ['title', 'description'],
                'like' => 'this is a test',
            ],
        ];

        static::assertEquals($expected, $query->toArray());
    }
}
