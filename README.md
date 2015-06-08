This is a [test for BBC iPlayer](https://github.com/iplayer/hiring/blob/master/azListing.md), involving converting a JSON feed into a HTML representation with pagination.

# Setup
Install dependencies:

`composer install`

Start the server:

`php -S 127.0.0.1:8000 -t webapp`

Go to http://127.0.0.1:8000/ in your browser to see the prototype!

# Design justification
As we only had two hours to digest the problem and create a prototype, and given the small amount of PHP code itself, I felt that it was not worth testing. There was very little that could be unit tested, but if I'd had more time, I would adopt an integration test framework such as Ruby and Cucumber to test the end-to-end functionality of the application.

I've used [Fat-Free Framework](http://fatfreeframework.com) to provide an MVCR architecture for me (installable via [Composer](https://getcomposer.org/)), and [Bootstrap](http://getbootstrap.com/) to provide a responsive UI framework.

If this were to go into production, I'd make sure to cache the values of the A-Z API every 10 minutes or so rather than calling the API every time, as it is quite slow.

# Issues
The challenge stated to include images, but the URLs in the JSON feed triggered a 403 Forbidden error, despite filling in the recipes. I've [created an issue](https://github.com/iplayer/hiring/issues/1) for this. For the time being, my compromise is to display the HTML I would use if the images were working.

The challenge also stated that the API supports "any single letter or 0-9", but putting any of the 0-9 values into the API raises an error:

```json
{"version":"1.0","schema":"/ibl/v1/schema/ibl.json","error":{"details":"Invalid letter parameter. Must be [a-z]|(0-9)]","http_response_code":400}}
```

Example: https://ibl.api.bbci.co.uk/ibl/v1/atoz/1/programmes?page=1
