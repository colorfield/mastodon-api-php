<?php

require __DIR__ . '/vendor/autoload.php';

// Make a copy of credentials.example.php
// and define the the values obtained with
// testOAuth.php + your Mastodon email and password.
require_once('test_credentials.php');

$name = 'MyMastodonApp';
$instance = 'mastodon.social';
$oAuth = new Colorfield\Mastodon\MastodonOAuth($name, $instance);
$oAuth->config->setClientId($client_id);
$oAuth->config->setClientSecret($client_secret);
$oAuth->config->setBearer($bearer);
$mastodonAPI = new Colorfield\Mastodon\MastodonAPI($oAuth->config);

$login = $oAuth->authenticateUser($mastodon_email, $mastodon_password);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Test Mastodon API | </title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        h3 {
            margin-top: 2rem;
        }
        .row {
            margin-bottom: 1rem;
        }
        .row .row {
            margin-top: 1rem;
            margin-bottom: 0;
        }
        [class*="col-"] {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: rgba(86, 61, 124, .15);
            border: 1px solid rgba(86, 61, 124, .2);
        }
        hr {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
<div class="container">

    <h1>Test Mastodon API</h1>

    <p>@todo replace examples by get, post, delete, stream usage.</p>

    <h2>Use the API wrapper</h2>
    <div class="row">
        <div class="col-md-4">/accounts/verify_credentials</div>
        <div class="col-md-8">
          <?php
          $credentials = $mastodonAPI->get('/accounts/verify_credentials');
          var_dump($credentials);
          ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">/accounts/USER_ID/followers</div>
        <div class="col-md-8">
          <?php
          $followers = $mastodonAPI->get('/accounts/' . $credentials['id'] . '/followers');
          var_dump($followers);
          ?>
        </div>
    </div>

</div> <!-- /container -->
</body>
</html>
