pushover-net
============

Simple, standalone, clean PHP wrapper for the pushover.net API

MASTER : [![Build Status](https://travis-ci.org/EVODelavega/pushover-net.svg?branch=master)](https://travis-ci.org/EVODelavega/pushover-net)
BETA   : [![Build Status](https://travis-ci.org/EVODelavega/pushover-net.svg?branch=feature%2Fbeta)](https://travis-ci.org/EVODelavega/pushover-net)
PHP5.3 : [![Build Status](https://travis-ci.org/EVODelavega/pushover-net.svg?branch=version%2Fphp5-3)](https://travis-ci.org/EVODelavega/pushover-net)

### A basic example (push a message):

Pushing a message is quite simple. But unlike other wrappers I've seen, it is equally easy to validate users and groups,
Check receipts for pushed message, choose the sounds (through constants) etc...

Here's a simple example:

```php
<?php
$credentials = new Credentials(
    'APP token',
    'user API'
);

//API settings array
$apiSettings = [
    'baseUrl'   => 'the url',//default works fine
    'output'    => Api::OUTPUT_JSON
];

//create message object
$message = new Message(
    [
        'message'  => 'The message',
        'title'    => 'The title',
        'priority' => Message::PRIORITY_EMERGENCY,
        'sound'    => Message::SOUND_GAME
    ],
    $credentials
);

//USING THE WRAPPER:
//get API section:
$api = Api::GetApiSection(
    Api::SECTION_PUSH,//get push section,
    $apiSettings
);

//push message
$response = $api->pushMessage($message);

//check receipt, alternative way of creating API wrapper:
$api = new Receipt($apiSettings);

//get the receipt for the response
$receipt = $api->getReceipt(
    $response,
    $credentials
);

```

Bascially, this example serves to show that, after constructing the `Credentials` class, the use of the API is pretty
straightforward. After all things have been set up, it's a simple matter of passing through objects.

If anything goes wrong, an appropriate exception will be thrown.

## What can this wrapper do?

Good question. Put simply this is a minimalistic setup which allows you to:

- Push messages (examples/example.php shows you how)
- Validate users, groups and their devices
- Process receipts, if you want to
- Easily extend the functionality (look at the base classes `PushOver\Api` and `PushOver\Model\Data`)

## What can't it do (yet)?

Another good question. Things that are missing from this wrapper (but will be added shortly) are:

- Support for XML formatted responses (will not be added any time soon)
- Unit tests (Are being added now)
- Improve data-model consistency, and make the overall API more consistent

What might be added in the future?

- Better error/exception handling
- Consistency tweaks (return values/property types)
- Data models should implement the `\Traversable` interface somehow
- ...

I'm open to suggestions, so if there's something you're looking for and, like me, found the existing wrappers lacking: create an issue, and I'll be happy to look into it

### Getting the example.php script to work

It's as simple as creating the `params.json` file in the examples directory. The JSON should look something like:

```json
{
    "credentials": {
        "user": "<your user string>",
        "token": "<the API token>"
    },
    "api": {
        "baseUrl": "base url like: https://api.pushover.net/1/",
        "output": ".json (or, when added .xml, xml is currently unsupported)"
    }
}
```

If you're trying to use the `Api::GetApiSection` method to load an API class other than `PushOver\Push`, don't forget to `require` it (or better yet, register the autoloader composer will helpfully give you)

That's it!

==========

# Contributing is optional, but encouraged.

If you see room for improvement, or want to make a suggestion: don't hold back, create issues. Fork, create pull requests... the works. Collaborating is fun.
