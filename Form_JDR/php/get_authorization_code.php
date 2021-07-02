
<?php
require('config.php');
$params = array(
    'response_type' => 'code',
    'client_id' => CLIENT_ID,
    'redirect_uri' => 'http://93.11.4.50.nip.io/php/get_token.php',
    'scope' => 'identify'
);
header('Location: https://discordapp.com/api/oauth2/authorize?' . http_build_query($params));
die();	
?>