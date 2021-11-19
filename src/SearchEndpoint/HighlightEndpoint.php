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

use ONGR\ElasticsearchDSL\BuilderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search highlight dsl endpoint.
 */
class HighlightEndpoint extends AbstractSearchEndpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'highlight';

    /**
     * @var BuilderInterface|null
     */
    private $highlight;

    /**
     * @return array|bool|float|int|string|null
     */
    public function normalize(NormalizerInterface $normalizer, ?string $format = null, array $context = [])
    {
        if ($this->highlight) {
            return $this->highlight->toArray();
        }

        return null;
    }

    public function add(BuilderInterface $builder, $key = null)
    {
        if ($this->highlight) {
            throw new \OverflowException('Only one highlight can be set');
        }

        $this->highlight = $builder;

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($boolType = null)
    {
        return ['' => $this->getHighlight()];
    }

    /**
     * @return BuilderInterface
     */
    public function getHighlight()
    {
        return $this->highlight;
    }
}
