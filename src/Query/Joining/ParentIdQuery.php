<?php declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Query\Joining;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-parent-id-query.html
 */
class ParentIdQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $childType;

    /**
     * @var string
     */
    private $parentId;

    /**
     * @param string $parentId
     */
    public function __construct($parentId, string $childType, array $parameters = [])
    {
        $this->childType = $childType;
        $this->parentId = $parentId;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'parent_id';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'id' => $this->parentId,
            'type' => $this->childType,
        ];
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
