<?php

require __DIR__ . '/vendor/autoload.php';

$name = 'MyMastodonApp';
$instance = 'mastodon.social';
$oAuth = new Colorfield\Mastodon\MastodonOAuth($name, $instance);

$authorizationUrl = $oAuth->getAuthorizationUrl();

// @todo set php wrappers to be called from js
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Test Mastodon API | oAuth</title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          rel="stylesheet">
    <script
            src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
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
    <script type="text/javascript">

      $(document).ready(function() {

        function getToken() {

          var authData = {
            'grant_type': "authorization_code",
            'redirect_uri': "urn:ietf:wg:oauth:2.0:oob",
            'client_id': $("#client_id").text(),
            'client_secret': $("#client_secret").text(),
            'code': $('input[name=auth-code]').val()
          };

          console.log(authData);

          $('#bearer').html('sending...');

          // process the form
          $.ajax({
            type        : 'POST',
            url         : 'https://<?php echo $instance; ?>/oauth/token',
            data        : authData,
            dataType    : 'json',
            encode      : true
          })
          // using the done promise callback
            .done(function(data) {
              if(data.error) {
                $('#bearer').html(data.error_description);
              }else{
                $('#bearer').html(data.access_token);
              }
            });
        }

        function login() {

          var authData = {
            'grant_type': "password",
            'client_id': $("#client_id").text(),
            'client_secret': $("#client_secret").text(),
            'username': $('input[name=email]').val(),
            'password': $('input[name=password]').val(),
            'scope': 'read write'
          };

          console.log(authData);

          $('#login-result').html('sending...');

          // process the form
          $.ajax({
            type        : 'POST',
            url         : 'https://<?php echo $instance; ?>/oauth/token',
            data        : authData,
            dataType    : 'json',
            encode      : true
          })
          // using the done promise callback
            .done(function(data) {
              if(data.error) {
                $('#login-result').html(data.error_description);
              }else{
                $('#login-result').html('Login OK - Bearer:' + data.access_token);
              }
            });
        }

        // process the forms
        $('.get-access-token').on('click', function(e) {
          e.preventDefault();
          getToken();
        });

        $('.login').on('click', function(e) {
          e.preventDefault();
          login();
        });

      });

    </script>
</head>

<body>
<div class="container">

    <h1>Test Mastodon API</h1>

    <h2>Authenticate</h2>
    <h4>1. Click on authorize and get the auth code</h4>
    <div class="row">
        <div class="col-md-4">client_id</div>
        <div class="col-md-8" id="client_id"><?php echo $oAuth->config->getClientId(); ?></div>
    </div>
    <div class="row">
        <div class="col-md-4">client_secret</div>
        <div class="col-md-8" id="client_secret"><?php echo $oAuth->config->getClientSecret(); ?></div>
    </div>
    <div class="row">
        <div class="col-md-4">authorization_url</div>
        <div class="col-md-8" id="authorization_url"><a href="<?php echo $authorizationUrl ?>"
                                 target="_blank">Authorize</a></div>
    </div>

    <h4>2. Paste the auth code in this form then submit</h4>

    <form id="access-token">
        <div class="form-group row">
            <div class="col-md-4">
                <label for="auth-code">Auth code</label>
            </div>
            <div class="col-md-8">
                <input class="form-control" type="text" value="" placeholder="Paste the code" name="auth-code">
            </div>
        </div>
        <button type="submit" class="btn btn-primary get-access-token">Get access token</button>
    </form>

    <div class="row"></div>

    <h4>3. Login with the bearer + email and password</h4>

    <div class="row">
        <div class="col-md-4">bearer</div>
        <div class="col-md-8" id="bearer"></div>
    </div>

    <form id="login">
        <div class="form-group row">
            <div class="col-md-4">
                <label for="auth-code">Email</label>
            </div>
            <div class="col-md-8">
                <input class="form-control" type="email" value="" placeholder="Email" name="email">
            </div>
            <div class="col-md-4">
                <label for="auth-code">Password</label>
            </div>
            <div class="col-md-8">
                <input class="form-control" type="password" value="" placeholder="Password" name="password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary login">Login</button>
    </form>

    <div class="row"></div>

    <div class="row">
        <div class="col-md-4">login result</div>
        <div class="col-md-8" id="login-result"></div>
    </div>

    <h2>Use the API wrapper</h2>

    <p>Go to <em><a href="test_api.php">test_api.php</a></em> in your browser after having defined the <em>test_credentials.php</em> file.</a></p>

</div> <!-- /container -->
</body>
</html>
