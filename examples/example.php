<?php

require '../src/PushOver/Model/Data.php';
require '../src/PushOver/Model/Credentials.php';
require '../src/PushOver/Model/Message.php';
require '../src/PushOver/Model/Response.php';
require '../src/PushOver/Api.php';
require '../src/PushOver/Push.php';

use PushOver\Push,
    PushOver\Model\Credentials,
    PushOver\Model\Message;

$params = json_decode(
    file_get_contents('params.json')
);

$credentials = new Credentials(
    $params->credentials->token,
    $params->credentials->user
);

$api = new Push(
    [
        'baseUrl'   => $params->api->baseUrl,
        'output'    => $params->api->output
    ]
);

$message = new Message(
    [
        'message'   => 'This is an example test message',
        'title'     => 'example',
        'priority'  => Message::PRIORITY_HIGH,
        'sound'     => Message::SOUND_COSMIC
    ],
    $credentials
);
$response = $api->pushMessage($message);

die(
    var_dump(
        $response
    )
);