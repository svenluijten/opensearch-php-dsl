<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Functional\Query;

use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Tests\Functional\AbstractElasticsearchTestCase;

/**
 * @internal
 */
class MatchAllQueryTest extends AbstractElasticsearchTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getDataArray()
    {
        return [
            'product' => [
                [
                    'title' => 'acme',
                ],
                [
                    'title' => 'foo',
                ],
            ],
        ];
    }

    /**
     * Match all test
     */
    public function testMatchAll(): void
    {
        $search = new Search();
        $matchAll = new MatchAllQuery();

        $search->addQuery($matchAll);
        $q = $search->getQueries();
        $results = $this->executeSearch($search);

        $this->assertEquals($this->getDataArray()['product'], $results);
    }
}
