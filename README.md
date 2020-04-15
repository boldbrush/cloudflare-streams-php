# BoldBrush Cloudflare Streams

## Installation

```bash
$ composer require boldbrush/cloudflare-streams-php
```

## Usage

```php
require '../vendor/autoload.php';

use BoldBrush\Cloudflare\API;

/** @var API\Enpoints\Streams */
$api = API\Factory::make(
    '<account>',
    '<apiKey>',
    '<email>'
);
```

Get List of streams:

```php
/** @var API\Response\Stream[] */
$streams = $api->getStreams();
```

Get details of a stream:

```php
/** @var API\Response\Stream */
$stream = $api->getStream('<uid>');
```

Upload a stream from URL:

```php
/** @var API\Response\Stream */
$stream = $api->copy('<url>');
```

Delete a stream:

```php
/** @var bool */
$success = $api->delete('<uid>');
```

Get the embed snippet for a stream:

```php
/** @var string */
$html = $api->getEmbedSnippet('<uid>')
```