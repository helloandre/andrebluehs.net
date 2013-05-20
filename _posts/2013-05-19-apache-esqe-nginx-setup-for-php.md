---
title: Apache-esqe Nginx Setup For PHP
date: 2013-05-19
layout: post
---
If you're here looking for the config file you'll need, it's directly below here. If you want the story behind why I made it and am now posting it, keep reading.

This assumes that you're using [php5-fpm][2] to serve php.

## This Is The Nginx Config You're Looking For

{% highlight nginx linenos %}
server {
    listen 80;
    root /path/to/your/folder/;
    server_name your.domain.tld;
    index index.php;

    # In case you have any .htaccess files carrying over
    location ~ /\.ht {
        deny all;
    }

    # allow all ".php" files to be executed
    location ~ \.php {
        fastcgi_pass 127.0.0.1:9000;
        include fastcgi_params;
    }

    # This is for use with any frameworks that rewrite urls (pretty urls)
    # that don't necessarily end with ".php"
    #location ~ ^/(.*)$ {
    #    # Serving non-php files makes fpm not happy, so exlude them from being passed
    #    location ~ \.[^css|js|jpg|jpeg|png|gif]$ {
    #        fastcgi_pass 127.0.0.1:9000;
    #        include fastcgi_params;
    #    }
    #    try_files $uri /index.php; # add any params your framework needs here
    #}
}
{% endhighlight %}

## The Story

Recently I was hacking on something for [Houston Hackaton][1] and our group was ready to present, we just needed to throw our project on publicly-accessible server and we were ready to go.

"Hey, I have two of those sitting around not doing much, I'll just throw it on one of them!" I said. We were already using one of them to host our code via git (not wanting to use github because for various reasons). 

However. I had recently moved both my servers to Nginx. While i'm enjoying the performance improvemnt and overhead memory savings, it can be a PITA to configure for people new to Nginx.

We were using the [Slim Framework][3] to make the development go a little faster, and it uses url rewriting to support it's routes. 

"Ok, fine, I'll just throw a 'try_files' in there and have it default to `index.php`" I thought. Not so fast there, kid. By default (and for very good security reasons) php5-fpm doesn't allow access to not-specifically-requested files. [Here's a really good explaination as to why][4] This meant that We were having problems with assets loading.

So that's my story. I added an extra location check to not pass the execution off to php5-fpm if it's not supposed to be a php file (i.e. specifically has a non-php extension).

[1]: http://www.houstonhackathon.com/
[2]: https://duckduckgo.com/?q=php+fpm+nginx
[3]: http://slimframework.com
[4]: https://nealpoole.com/blog/2011/04/setting-up-php-fastcgi-and-nginx-dont-trust-the-tutorials-check-your-configuration/