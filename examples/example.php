<?php

require '../src/PushOver/Model/Data.php';
require '../src/PushOver/Model/Credentials.php';
require '../src/PushOver/Model/Message.php';
require '../src/PushOver/Model/Response.php';
require '../src/PushOver/Api.php';
require '../src/PushOver/Push.php';

use PushOver\Push,
    PushOver\Api,
    PushOver\Model\Credentials,
    PushOver\Model\Message;

//get config params
$params = json_decode(
    file_get_contents('params.json')
);

//create credentials object
//allmost all calls need this,
//so it can be created separately, and passed around
$credentials = new Credentials(
    $params->credentials->token,
    $params->credentials->user
);

//create API section class separately
$api = new Push(
    array(
        'baseUrl'   => $params->api->baseUrl,
        'output'    => $params->api->output
    )
);
//alternative, using factory-like method @Api:
$pushApi = Api::GetApiSection(
    Api::SECTION_PUSH,
    array(
        'baseUrl'   => $params->api->baseUrl,
        'output'    => $params->api->output
    )
);

//create a message to send
$message = new Message(
    array(
        'message'   => 'This is an example test message',
        'title'     => 'example',
        'priority'  => Message::PRIORITY_HIGH,
        'sound'     => Message::SOUND_COSMIC
    ),
    //using these credentials
    $credentials
);
//push the message, returns an instance of the PushOver\Model\Response class
$response = $api->pushMessage($message);

//dump the response
var_dump(
    $response
);
