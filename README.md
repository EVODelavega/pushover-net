pushover-net
============

Simple, standalone, clean PHP wrapper for the pushover.net API

## What is working:

Put simply, creating a message and sending it is working just fine (check examples/example.php for a working code example).
Is it working fully? Not quite, the receipt part of messages is not quite there yet. Still, seeing as most (if not all) API wrappers out there focus mainly (or even only) on the pushing of messages, I've put this wrapper out there already.

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

That's it!
