# OpenSearch DSL

Introducing OpenSearch/Elasticsearch DSL library to provide objective query builder for [elasticsearch-php](https://github.com/elastic/elasticsearch-php) client. You can easily build any Elasticsearch query and transform it to an array.

This is a fork of `ongr-io/ElasticsearchDSL`, which will be more regularly updated. Thanks for ongr-io for building this Library!

If you need any help, [Github discussion](https://github.com/shyim/opensearch-dsl/discussions)
is the preferred and recommended way to ask support questions.

[![Test](https://github.com/shyim/opensearch-dsl/actions/workflows/test.yml/badge.svg)](https://github.com/shyim/opensearch-dsl/actions/workflows/test.yml)
[![codecov](https://codecov.io/gh/shyim/opensearch-dsl/branch/7.2/graph/badge.svg)](https://codecov.io/gh/shyim/opensearch-dsl)
[![Latest Stable Version](https://poser.pugx.org/shyim/opensearch-dsl/v/stable)](https://packagist.org/packages/shyim/opensearch-dsl)
[![Total Downloads](https://poser.pugx.org/shyim/opensearch-dsl/downloads)](https://packagist.org/packages/shyim/opensearch-dsl)


## Version matrix

### OpenSearch

| OpenSearch version | ElasticsearchDSL version    |
|--------------------| --------------------------- |
| >= 1.0             | >= 7.0                      |
| >= 2.0             | >= 7.0                      |

### Elasticsearch

| Elasticsearch version | ElasticsearchDSL version    |
| --------------------- | --------------------------- |
| >= 7.0                | >= 7.0                      |
| >= 6.0, < 7.0         | >= 6.0 (not supported)      |
| >= 5.0, < 6.0         | >= 5.0 (not supported)      |
| >= 2.0, < 5.0         | >= 2.0 (not supported)      |
| >= 1.0, < 2.0         | 1.x (not supported)         |
| <= 0.90.x             | not supported               |

## Documentation

[The online documentation of the bundle is here](docs/index.md)

## Try it!

### Installation

Install library with [composer](https://getcomposer.org):

```bash
$ composer require shyim/opensearch-dsl
```

> [elasticsearch-php](https://github.com/elastic/elasticsearch-php) client is defined in the composer requirements, no need to install it.

### Search

The library is standalone and is not coupled with any framework. You can use it in any PHP project, the only requirement is composer.  Here's the example:

Create search:

```php
<?php

require 'vendor/autoload.php'; //Composer autoload

$client = ClientBuilder::create()->build(); //elasticsearch-php client

$matchAll = new OpenSearchDSL\Query\MatchAllQuery();

$search = new OpenSearchDSL\Search();
$search->addQuery($matchAll);

$params = [
'index' => 'your_index',
'body' => $search->toArray(),
];

$results = $client->search($params);
```

Opensearch DSL covers every Opensearch query, all examples can be found in [the documentation](docs/index.md)
