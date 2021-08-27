<?php declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\InnerHit;

use ONGR\ElasticsearchDSL\NameAwareTrait;
use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;
use ONGR\ElasticsearchDSL\Search;

abstract class AbstractInnerHit implements NamedBuilderInterface
{
    use NameAwareTrait;
    use ParametersTrait;

    private string $path;

    private ?Search $search;

    public function __construct(string $name, string $path, ?Search $search = null)
    {
        $this->setName($name);
        $this->setPath($path);
        $this->setSearch($search);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getSearch(): ?Search
    {
        return $this->search;
    }

    public function setSearch(?Search $search): self
    {
        $this->search = $search;

        return $this;
    }

    public function toArray(): array
    {
        $out = $this->getSearch() ? $this->getSearch()->toArray() : new \stdClass();

        return [
            $this->getPathType() => [
                $this->getPath() => $out,
            ],
        ];
    }

    private function getPathType(): ?string
    {
        switch ($this->getType()) {
            case NestedInnerHit::TYPE:
                $type = 'path';
                break;
            case ParentInnerHit::TYPE:
                $type = 'type';
                break;
            default:
                $type = null;
        }

        return $type;
    }
}
