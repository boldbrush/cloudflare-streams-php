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
 * account: set your account ID (can be found in your dashboard URL or when in a DNS zone)
 * apiKey: use your Global API key, together with your email address, or use 'api_token' as the email and use a configured API Token.
 * email: set your login email in combination with your Global API key, or set as 'api_token' combined with a configured API Token.

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