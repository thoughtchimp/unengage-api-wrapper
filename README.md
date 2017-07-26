# Unengage SDK for PHP

This repository contains the open source PHP SDK that allows you to access the Unengage API from your PHP app.


## Installation

The Unengage SDK can be installed with [Composer](https://getcomposer.org/). Run this command:

```sh
composer require thoughtchimp/unengage-api-wrapper
```

## Usage

> **Note:** This version of the Unengage SDK for PHP requires PHP 5.5 or greater.


#### Instantiating SDK

```php
use Unengage\API;

$api = API('Pass api_key here');
```

#### Get all streams

```php
$streams = $api->streams();
```

#### Get stream by ID

```php
$stream = $api->stream('Pass stream id here');
```

#### Create stream

```php
$stream = $api->createStream('Stream name', 'Stream description');
```

#### Update particular stream by ID

```php
$stream = $api->updateStream('STREAM_ID', 'Stream name updated', [
  'description' => 'This is the updated description'
]);
```

#### Delete stream by ID

```php
$response = $api->deleteStream('STREAM_ID');
```

#### Get stream social posts by passing stream id

```php
$posts = $api->streamSocialPosts('STREAM_ID', [
  'tags' => 'social, digital'
]);
```

#### Update social posts of a stream by passing post ids

```php
$response = $api->updateStreamSocialPosts('STREAM_ID', ['post_id_1','post_id_2'], [
  'is_sponsored'  => true,
  'tags'          => 'funny, hilarious',
  'status'        => 'draft'
]);
```

#### Delete stream by ID

```php
$response = $api->deleteStreamSocialPosts('STREAM_ID', ['post_id_1', 'post_id_2', 'post_id_3']);
```

#### Pin a particular social post of a particular stream

```php
$response = $api->pinStreamSocialPost('STREAM_ID', 'POST_ID');
```

#### Get list of all social feeds of a particular stream

```php
$feeds = $api->streamSocialFeeds('STREAM_ID');
```


#### Create social feed under a particular stream

```php
$feed = $api->createStreamSocialFeed('STREAM_ID', '@thoughtchimp', 'twitter', [
  'status'          => 'published',
  'tags'            => 'entertainment, video service, fun',
  'exclude.mentions'=> true,
  'exclude.retweets'=> false,
  'exclude.replies' => true,
  'filters.all'     => 'entertainment',
  'filters.any'     => 'funny, hilarious, enjoy',
  'filters.none'    => 'negative',
  'is_realtime'     => false
]);
```


#### Get a particular social feed by ID

```php
$feed = $api->streamSocialFeed('STREAM_ID', 'FEED_ID');
```


#### Update stream social feed

```php
$feed = $api->updateStreamSocialFeed('STREAM_ID', 'POST_ID', [
  'status'          => 'draft',
  'tags'            => 'social, digital, media',
  'exclude.mentions'=> false,
  'exclude.retweets'=> false,
  'exclude.replies' => true,
  'filters.all'     => 'entertainment',
  'filters.any'     => 'funny, hilarious, enjoy',
  'filters.none'    => 'negative',
  'is_realtime'     => true
]);
```

#### Delete social feed

```php
$response = $api->deleteStreamSocialFeed('STREAM_ID', 'FEED_ID');
```

#### Refresh stream social feed (Prioritizing feed)

```php
$response = $api->refreshStreamSocialFeed('STREAM_ID', 'FEED_ID');
```

#### Get all social accounts of a particular stream

```php
$accounts = $api->streamSocialAccounts('STREAM_ID');
```

#### Create stream social account

```php
$api->createStreamSocialAccount('STREAM_ID', NAME, USERNAME, UID, PLATFORM, TOKEN, [array of properties]);
$account = $api->createStreamSocialAccount('STREAM_ID', 'Rohit Khatri', 'rohit49khatri', '39478934', 'twitter', '39478skhf3948shkjfsdf', [
  'secret'        => 'Here secret goes if provided by the platform example twitter',
  'refresh_token' => 'Here secret goes if provided by the platform example youtube'
]);
```

Complete documentation is available [here](http://api.unengage.com/docs).
