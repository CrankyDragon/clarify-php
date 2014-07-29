<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$audio = new \Clarify\Bundle($apikey);

$items = $audio->index();

foreach ($items as $item) {
    $metadata = $audio->metadata->load($item['href']);

    print_r($metadata);
}
