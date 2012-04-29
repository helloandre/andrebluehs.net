---
layout: post
title: Ablu.us and Chrome Extension
---
I [recently created][1] a file hosting and url shortening service for myself: [http://ablu.us/][3]. Now as a pet project, i'm starting to get some feature creep action going on. Case in point: I just wrote a chrome extension to use this service.

That said, here is a link to download it if you actually want it:

###[INSTALL ablu.crx][2]

###CHANGELOG

version 0.2 now includes using fizl.us.

version 0.2.1 fixed an initial settings bug

version 0.3 don't remember fixes. but there were some!

It'll ask you if you really trust me, and to continue. And that's it.

I won't get into the nitty gritty details of HOW TO create your own chrome extension quite yet, but expect a blog post about it soon. Also, Google has a bunch of getting started tutorials that helped me so well it only took me about 2 hours to write this extension from scratch.

Some interesting things are as follows:

###These babies are written in javascript

This was news to me. I knew Firefox plugins are written in XUL, which is similar to javascript. Chrome extensions are written in plain, vanilla javascript. Not only that, the part that gets displayed is literally an html page that you can do whatever you want with. If you want to include jQuery, you can (mine does not). Any other library? yup. It also means that you can use any of the HTML 5 capabilities Chrome offers: local storage, canvas, image rotation.

This strikes me as a bit excessive as you can load an unlimited number of scripts from anywhere. Seems to me that this could be abused.

###Chrome allows copying to clipboard

That's right. You can copy things to clipboard just like in IE with
    document.execCommand('Copy')
This is exactly how similar URL Shortening extensions work. After seeing how awesome this is, I have to wonder... why doesn't Firefox support this? I don't see it being a security risk more than copying profanity into the clipboard. Whatever, it's nifty that chrome has it.

###Autoupdating is scary

Hoo dangle is it scary. What happens if the dev's life suddenly tanks and decides he wants to have your browser randomly redirect to a porn site at random intervals? If you have a previously installed extension of his and he decides to update this new functionality, he can (there are some caveats to this, like what permissions the extension already has). This could be problematic as it would be difficult to track down exactly what's causing this browser behavior. This has the potential to turn any previously useful and non-porn-redirecting extension into a very messy thing to be a part of.

If you are in the market for (another) url shortening extension, give it a try. Let me know what you think. It could probably use a much better logo, so if  you want to help drop me a line at hello at this domain.

[1]: http://andrebluehs.net/blog/2010/02/image-uploader-and-url-shortener/
[2]: http://ablu.us/files/custom-ext.crx
[3]: http://ablu.us/
