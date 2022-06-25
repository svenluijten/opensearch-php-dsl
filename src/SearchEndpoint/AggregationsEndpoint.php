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

use OpenSearchDSL\Aggregation\AbstractAggregation;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search aggregations dsl endpoint.
 */
class AggregationsEndpoint extends AbstractSearchEndpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'aggregations';

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, ?string $format = null, array $context = [])
    {
        $output = [];
        /** @var AbstractAggregation $aggregation */
        foreach ($this->getAll() as $aggregation) {
            $output[$aggregation->getName()] = $aggregation->toArray();
        }

        return $output;
    }
}
