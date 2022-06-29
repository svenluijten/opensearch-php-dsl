<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSearchDSL\SearchEndpoint;

/**
 * Factory for search endpoints.
 */
class SearchEndpointFactory
{
    /**
     * @var array holds namespaces for endpoints
     */
    private static $endpoints = [
        'query' => 'OpenSearchDSL\SearchEndpoint\QueryEndpoint',
        'post_filter' => 'OpenSearchDSL\SearchEndpoint\PostFilterEndpoint',
        'sort' => 'OpenSearchDSL\SearchEndpoint\SortEndpoint',
        'highlight' => 'OpenSearchDSL\SearchEndpoint\HighlightEndpoint',
        'aggregations' => 'OpenSearchDSL\SearchEndpoint\AggregationsEndpoint',
        'suggest' => 'OpenSearchDSL\SearchEndpoint\SuggestEndpoint',
        'inner_hits' => 'OpenSearchDSL\SearchEndpoint\InnerHitsEndpoint',
    ];

    /**
     * Returns a search endpoint instance.
     *
     * @param string $type type of endpoint
     *
     * @throws \RuntimeException endpoint does not exist
     *
     * @return AbstractSearchEndpoint
     */
    public static function get($type)
    {
        if (!array_key_exists($type, self::$endpoints)) {
            throw new \RuntimeException('Endpoint does not exist.');
        }

        return new self::$endpoints[$type]();
    }
}
