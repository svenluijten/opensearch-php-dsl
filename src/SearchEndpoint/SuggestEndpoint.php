<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use ONGR\ElasticsearchDSL\Suggest\Suggest;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search suggest dsl endpoint.
 */
class SuggestEndpoint extends AbstractSearchEndpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'suggest';

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, ?string $format = null, array $context = [])
    {
        $output = [];
        /** @var Suggest $suggest */
        foreach ($this->getAll() as $suggest) {
            $output = array_merge($output, $suggest->toArray());
        }

        return $output;
    }
}
