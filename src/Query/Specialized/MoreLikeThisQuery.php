<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\Specialized;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "more_like_this" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-mlt-query.html
 */
class MoreLikeThisQuery implements BuilderInterface
{
    use ParametersTrait;

    private string $like;

    public function __construct(string $like, array $parameters = [])
    {
        $this->like = $like;
        $this->setParameters($parameters);
    }

    public function toArray(): array
    {
        $query = [];

        if (($this->hasParameter('ids') === false) || ($this->hasParameter('docs') === false)) {
            $query['like'] = $this->like;
        }

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

    public function getType(): string
    {
        return 'more_like_this';
    }
}
