<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\InnerHit;

use ONGR\ElasticsearchDSL\NameAwareTrait;
use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;
use ONGR\ElasticsearchDSL\Search;

/**
 * Represents Elasticsearch top level nested inner hits.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-inner-hits.html
 */
class NestedInnerHit implements NamedBuilderInterface
{
    use NameAwareTrait;
    use ParametersTrait;

    /**
     * @var string
     */
    private $path;

    /**
     * @var Search
     */
    private $search;

    /**
     * Inner hits container init.
     *
     * @param string $name
     * @param string $path
     * @param Search $search
     */
    public function __construct($name, $path, ?Search $search = null)
    {
        $this->setName($name);
        $this->setPath($path);
        if ($search) {
            $this->setSearch($search);
        }
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Search
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @return $this
     */
    public function setSearch(Search $search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'nested';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $out = $this->getSearch() ? $this->getSearch()->toArray() : new \stdClass();

        return [
            $this->getPathType() => [
                $this->getPath() => $out,
            ],
        ];
    }

    /**
     * Returns 'path' for nested and 'type' for parent inner hits
     *
     * @return string|null
     */
    private function getPathType()
    {
        switch ($this->getType()) {
            case 'nested':
                $type = 'path';
                break;
            case 'parent':
                $type = 'type';
                break;
            default:
                $type = null;
        }

        return $type;
    }
}
