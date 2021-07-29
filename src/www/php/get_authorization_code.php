
<?php
require('config.php');
$params = array(
    'response_type' => 'code',
    'client_id' => CLIENT_ID,
    'redirect_uri' => 'http://babylyss.com/php/get_token.php',
    'scope' => 'identify'
);
header('Location: https://discordapp.com/api/oauth2/authorize?' . http_build_query($params));
die();	
?>
