pushover-net
============

Simple, standalone, clean PHP wrapper for the pushover.net API

## What can this wrapper do?

Good question. Put simply this is a minimalistic setup which allows you to:

- Push messages (examples/example.php shows you how)
- Validate users, groups and their devices
- Process receipts, if you want to
- Easily extend the functionality (look at the base classes `PushOver\Api` and `PushOver\Model\Data`)

## What can't it do (yet)?

Another good question. Things that are missing from this wrapper (but will be added shortly) are:

- Support for XML formatted responses
- More examples
- Unit tests
- Improve data-model consistency, and make the overall API more consistent

What might be added in the future?

- Better error/exception handling
- Data models should implement the `\Traversable` interface somehow
- A php 5.3 compatible branch??
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
