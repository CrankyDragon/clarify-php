<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
include __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$terms = $_GET['terms'];
$terms = preg_replace("/[^A-Za-z0-9|]/", "", $terms);

$video = new \Clarify\Bundle($apikey);
$items = $video->search($terms);

$search_terms = json_encode($items['search_terms']);
$item_results = json_encode($items['item_results']);

$videokey = $items['_links']['items'][0]['href'];
$tracks = $video->tracks->load($videokey)['tracks'];

$mediaUrl = $tracks[0]['media_url'];
$duration = $tracks[0]['duration'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <title>Clarify Video Player Demo</title>
    <style type="text/css">
        body { font-family: sans-serif; }
    </style>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script src="scripts/jquery/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
    <script src="scripts/jquery/jquery.jplayer-2.6.0.min.js" type="text/javascript"></script>
    <script src="scripts/o3v_video_player.js" type="text/javascript"></script>

    <link rel="stylesheet" href="css/jquery-ui.custom.css"/>
    <link rel="stylesheet" href="css/o3v-player.css"/>

    <script type="text/javascript">
        $(document).ready(function() {

            // Set the path to the jplayer swf file.
            o3vPlayer.jPlayerOptions.swfPath = 'scripts/jquery';

            // Set to the playback URL for the video file(s).
            var mediaURLs = { m4v:"http://media.swagit.com/podcasts/2014/05/31/05312014-504.360.mp4",
                poster:"http://stills.swagit.com/swagit/swagit/05312014-504.480x360.jpg"};

            ////////////////////////////////////////////////////////

            // This is a sample search_terms array from a SearchCollection
            var searchTerms = <?php echo $search_terms; ?>;

            // This is a sample "ItemResult" object from a SearchCollection JSON
            // object. It is one item in the item_results array.
            var itemResult =  <?php echo $item_results; ?>;

            ////////////////////////////////////////////////////////

            // Create a player and add in search results marks

            var convDuration = <?php echo $duration; ?>;
            var player = o3vPlayer.createPlayer("#player_instance_1",mediaURLs, convDuration,{volume:0.5});
            o3vPlayer.addItemResultMarkers(player, convDuration, itemResult, searchTerms);


            ////////////////////////////////////////////////////////
            // Create words tags for SearchCollection.

            for (var i=0,c=searchTerms.length;i<c;i++) {
                var term = searchTerms[i].term;
                var dtag = document.createElement('div');
                $(dtag).addClass("o3v-search-tag o3v-search-color-"+i);
                $(dtag).text(term);
                $("#player_1_search_tags").append(dtag);
            }
            dtag = document.createElement('div');
            $(dtag).addClass("o3v-clear");
            $("#player_1_search_tags").append(dtag);
            ////////////////////////////////////////////////////////

        });
    </script>

</head>
    <body>
        <h3>Clarify JPlayer Video Demo</h3>
        <form action="" method="GET">
            Search terms: <input name="terms" value="" />
            <input type="submit" />
        </form>
        <br>
        Player Example:
        <br>
        <em>If no video player appears, there was not a search result found.</em>
        <br>
        <div id="player_1_search_tags" class="o3v-search-tag-box"></div>
        <div id="player_instance_1"></div>
    </body>
</html>
