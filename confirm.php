<?php

use GuzzleHttp\Exception\GuzzleException;

require('constants.php');
require('src/ApiClient.php');

$client = new ApiClient('https://api.global-sandbox.affirm.com/');

try {
    $authorizeResponse = $client->call('POST', 'api/v1/transactions', [
            'order_id' => $_POST['checkout_token'],
            'transaction_id' => $_POST['checkout_token'],
        ]
    );
} catch (GuzzleException $e) {
    $error = $e;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirm transaction</title>
</head>
<body>
    <h1>Order confirmation</h1>
    <p>Response:</p>
    <p>
        <?php
            if (isset($error)) {
                print "
                    <div style=\"background-color: burlywood; padding: 1em;\">
                        <h2>Error code {$error->getCode()}</h2>
                        <h3>{$error->getMessage()}</h3>
                        <p>{$error->getTraceAsString()}</p>                    
                    </div>
                ";
            } elseif ($authorizeResponse->getStatusCode() === 200) {
                $response = json_decode($authorizeResponse->getBody());
                print "<p>Payment was sucessfully authorized with id {$response->id}.</p>";
            }
        ?>
    </p>
    <a href="/index.php">Go back to checkout</a>
</body>
</html>