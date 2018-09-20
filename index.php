<?php
  require 'vendor/autoload.php';

  use Symfony\Component\Dotenv\Dotenv;

  $dotenv = new Dotenv();
  $dotenv->load(__DIR__.'/.env');

  $api_key = getenv('API_KEY');

  function displayMenu() {
    echo "\n";
    echo 'Choose an option: ' . "\n";
    echo '1: Non-embedded signature request' . "\n";
    echo '2: Get Account' . "\n";
    echo "3: Signature request using REST call" . "\n";
    echo "\n";

  };

  if ($argv[1] == '1') {
    signatureRequest($api_key);
  } elseif ($argv[1] == '2') {
    getAccount($api_key);
  } elseif ($argv[1] == '3') {
    signRequestWithRest($api_key);
  }
  displayMenu();

  function signatureRequest($key) {
    $client = new HelloSign\Client($key);
    $request = new HelloSign\SignatureRequest;
    $request->enableTestMode();
    $request->setTitle('NDA with Acme');
    $request->setSubject('The NDA');
    $request->setMessage('Please sign this!');
    $request->addSigner('james.mccormack@hellosign.com', 'James');
    $request->addFile('faketaxes2.pdf');
    $response = $client->sendSignatureRequest($request);
    print_r($response);
  };

  function getAccount($key) {
    $url = 'https://'.$key.':@api.hellosign.com/v3/account';
    $response = \Httpful\Request::get($url)->send();
    echo "\n" . $response . "\n";
  };

  // currently having issues with formatting signers param in the JSON to work properly.
  function signRequestWithRest($key) {
    $url = 'https://'.$key.':@api.hellosign.com/v3/signature_request/send';
    $response = \Httpful\Request::post($url)
      ->sendsJson()
      ->body('{
        "test_mode": 1,
        "title": "Important document",
        "subject": "Please sign",
        "message": "Sign today!",
        "signers": [{
          "name": "James",
          "email_address": "james.mccormack@hellosign.com"
        }],
        "file": {"./faketaxes2.pdf"}
      }')
      ->send();
      echo $response;
  };

?>
