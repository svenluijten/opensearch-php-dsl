<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\TermLevel;

use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Represents Elasticsearch "type" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-type-query.html
 */
class TypeQuery implements BuilderInterface
{
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function toArray(): array
    {
        return [
            $this->getType() => [
                'value' => $this->type,
            ],
        ];
    }

    public function getType(): string
    {
        return 'type';
    }
}
