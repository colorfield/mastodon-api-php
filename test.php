<?php

require __DIR__ . '/vendor/autoload.php';

$name = 'MyMastodonApp';
$instance = 'mastodon.social';
$oAuth = new Colorfield\Mastodon\MastodonOAuth($name, $instance);

$authorizationUrl = $oAuth->getAuthorizationUrl();

// @todo then go to url and get the authorization code
//$oAuth->authenticate(\'xxx\');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Test Mastodon API</title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet">
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
        background-color: rgba(86,61,124,.15);
        border: 1px solid rgba(86,61,124,.2);
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

      <h3>Authenticate</h3>
      <div class="row">
        <div class="col-md-4">client_id</div>
        <div class="col-md-8"><?php echo $oAuth->config->getClientId(); ?></div>
      </div>
      <div class="row">
        <div class="col-md-4">client_secret</div>
        <div class="col-md-8"><?php echo $oAuth->config->getClientSecret(); ?></div>
      </div>
      <div class="row">
        <div class="col-md-4">authorization url</div>
        <div class="col-md-8"><a href="<?php echo $authorizationUrl ?>" target="_blank">Authorize</a></div>
      </div>

      <h3>Use the API wrapper</h3>

      <p>@todo</p>

    </div> <!-- /container -->
  </body>
</html>
