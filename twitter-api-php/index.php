<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "910018483391307776-6cqBmenSzqJJwic6we7BB0QgAaY9yVk",
    'oauth_access_token_secret' => "eCC7UuIEBxui6qCT1LkFA3Wy8J0l9Chn37QOvnJ0aYTXv",
    'consumer_key' => "zkIrma1nO3IjrZceudSKLPjQ4",
    'consumer_secret' => "Bl5BcxwyTXLlL7ZPnU3XMvjCi7B2bbtdBPwTZp4geOa1vlKLyL"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$requestMethod = 'GET';

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$getfield = '?q='.$_GET['q'];
$twitter = new TwitterAPIExchange($settings);
$result = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
$result = json_decode($result);
$result = $result->statuses;

?>

<table>
    <?php foreach ($result as $key => $result): ?>
        <tr>
            <td>
                <img src="<?php echo $result->user->profile_image_url; ?>" alt="profile image">
            </td>
            <td>
                <b><?php echo $result->user->screen_name; ?></b> <br>
                <?php echo $result->text; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
