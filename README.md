# OpenSearch DSL

Introducing OpenSearch DSL library to provide objective query builder for [opensearch-php](https://github.com/opensearch-project/opensearch-php) client. You can easily build any Opensearch query and transform it to an array.

This is a fork of `ongr-io/ElasticsearchDSL`, which will be more regularly updated. Thanks for ongr-io for building this Library!

If you need any help, [Github issues](https://github.com/shyim/opensearch-dsl/issues) is the preferred and recommended way to ask support questions.

[![Test](https://github.com/shyim/opensearch-php-dsl/actions/workflows/test.yml/badge.svg)](https://github.com/shyim/opensearch-php-dsl/actions/workflows/test.yml)
[![codecov](https://codecov.io/gh/shyim/opensearch-php-dsl/branch/main/graph/badge.svg)](https://codecov.io/gh/shyim/opensearch-php-dsl)
[![Latest Stable Version](https://poser.pugx.org/shyim/opensearch-php-dsl/v/stable)](https://packagist.org/packages/shyim/opensearch-php-dsl)
[![Total Downloads](https://poser.pugx.org/shyim/opensearch-php-dsl/downloads)](https://packagist.org/packages/shyim/opensearch-php-dsl)


## Version matrix

| OpenSearch version | OpenSearchDSL version |
|--------------------|-----------------------|
| >= 1.0             | >= 1.0                |
| >= 2.0             | >= 1.0                |

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

$client = ClientBuilder::create()->build(); //opensearch-php client

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
