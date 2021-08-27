<?php declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Type;

interface TypeInterface
{
    public function toArray(): array;
}
