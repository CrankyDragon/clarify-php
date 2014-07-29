<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$audio = new \Clarify\Bundle($apikey);

$items = $audio->index();

/**
 * This gets the first item from our list of bundles, shows the existing tracks, adds three audio tracks, and then
 *   shows the new list of tracks.
 */
foreach ($items as $item) {
    $tracks = $audio->tracks->load($item['href']);
    print_r($tracks);

    $success = $audio->tracks->create(
        array(
            'id' => $item['href'],
            'media_url' => 'https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-1.wav',
        )
    );
    $success = $audio->tracks->create(
        array(
            'id' => $item['href'],
            'media_url' => 'https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-2.wav',
        )
    );
    $success = $audio->tracks->create(
        array(
            'id' => $item['href'],
            'media_url' => 'https://s3-us-west-2.amazonaws.com/op3nvoice/dorothyandthewizardinoz_01_baum_64kb.mp3',
        )
    );

    $tracks = $audio->tracks->load($item['href']);
    print_r($tracks);
    die();
}
