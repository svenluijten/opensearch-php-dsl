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

use OpenSearchDSL\BuilderInterface;
use OpenSearchDSL\Query\Compound\BoolQuery;
use OpenSearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search query dsl endpoint.
 */
class QueryEndpoint extends AbstractSearchEndpoint implements OrderedNormalizerInterface
{
    /**
     * Endpoint name
     */
    public const NAME = 'query';

    /**
     * @var BoolQuery|null
     */
    private $bool;

    /**
     * @var bool
     */
    private $filtersSet = false;

    /**
     * @return array|bool|float|int|string|null
     */
    public function normalize(NormalizerInterface $normalizer, ?string $format = null, array $context = [])
    {
        if (!$this->filtersSet && $this->hasReference('filter_query')) {
            /** @var BuilderInterface $filter */
            $filter = $this->getReference('filter_query');
            $this->addToBool($filter, BoolQuery::FILTER);
            $this->filtersSet = true;
        }

        if (!$this->bool) {
            return null;
        }

        return $this->bool->toArray();
    }

    public function add(BuilderInterface $builder, ?string $key = null): string
    {
        return $this->addToBool($builder, BoolQuery::MUST, $key);
    }

    public function addToBool(BuilderInterface $builder, ?string $boolType = null, $key = null): string
    {
        if (!$this->bool) {
            $this->bool = new BoolQuery();
        }

        return $this->bool->add($builder, $boolType, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * @return BoolQuery|null
     */
    public function getBool()
    {
        return $this->bool;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($boolType = null)
    {
        return $this->bool->getQueries($boolType);
    }
}
