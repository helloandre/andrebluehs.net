---
layout: post
title: Image Uploader and URL Shortener
---

I recently purchased the url ablu.us with the intention of using it as a url shortener/image uploader. So i did.

It was actually quite trivial, and I had the code for it done about 6 months ago, but didn't purchase the url till recently. I had created a photo uploader for another website I was working on ([newnantheatre.org][1]) so I just copied over the code (I wasn't getting paid anyway, so I felt it was ok to reuse the code). There are some improvements tho that I'll document here. However, I'm not actually going into the implementation of a url shortener or image uploader. You should take a weekend and figure this out for yourself. Or maybe I'll do a post on it later.

###Resize Me

The first thing I wanted was for people to not have to scroll horizontally to see huge pictures. But I didn't want to resize them during the upload process, because I wanted people to see them the largest possible. So i wrote a quick jQuery script to detect the window size/proportions, and resize the image to that roughly. There are still some bugs in this, and currently there is no way to see the actual real size image without going to the hotlink.

###mod_rewrite

This was a huge thing, as I had just started experimenting with it recently. I'm not a fan of big, scary regular expressions, but they're damn useful (and necessary) when it comes to `mod_rewrite`. For those of you who don't know what this is, it's pretty urls. It takes the part after the .com, .net, .us, etc, and turns it into a meaningful request to the script that is actually being accessed. This was particularly useful for url shortening because it removes the need for a `?x=xxx` at the end of a url.

###api

In the case of the url shortening, i created a dead simple api to use. This can be used as a bookmarklet with any browser that supports them (Firefox, Chrome (only tested in dev builds), Safari, etc). Just paste this code into the url part of a bookmark to create a bookmarklet:

{% highlight javascript %}
javascript:void(window.location='http://ablu.us/s/up.php?site='+location.href)
{% endhighlight %}

Or you can visit [http://ablu.us/][3] and copy the url you want to shorten and click 'Shorten'. Or you can use it in any other context of plugin, extension, etc for url shortening purposes by using the url `http://ablu.us/up.php?site=`

##EDIT: Chrome Extension

I have written a [chrome extension][2] for this as well.

[1]: http://newnantheatre.org
[2]: http://andre.blue/blog/2010/02/ablu-us-and-chrome-extensions/
[3]: http://ablu.us
