<?php declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Tests\Unit\InnerHit;

use ONGR\ElasticsearchDSL\InnerHit\ParentInnerHit;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Search;

/**
 * @internal
 */
class ParentInnerHitTest extends \PHPUnit\Framework\TestCase
{
    public function testToArray(): void
    {
        $query = new TermQuery('foo', 'bar');
        $search = new Search();
        $search->addQuery($query);

        $hit = new ParentInnerHit('test', 'acme', $search);
        $expected = [
            'type' => [
                'acme' => [
                    'query' => $query->toArray(),
                ],
            ],
        ];
        static::assertEquals($expected, $hit->toArray());
    }
}
