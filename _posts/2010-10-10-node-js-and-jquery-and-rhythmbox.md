---
layout: post
title: Node.js and jQuery and Rhythmbox
---
I wrote a node.js server that listens on port 3000 (with an index page to be served by a regular server) that can do rudimentary control of rhythmbox.

Dependencies:

 - Rhythmbox
 - Node.js
 - Express

##TLDR: [Download Playr from github][1].

###The Premise

I wanted to be able to control my Rhythmbox from my phone, but didn’t want to build a special app to do so. So I set about building something in php to control it. I thought I would be able to use the `rhythmbox-client` command line tool I use with Compiz’s ‘Commands’ to map things to my keyboard and mouse buttons.

Boy was I wrong.

###Linux and it’s Multiple-User architecture suck

So first I tried to use the command-line and php’s `exec` to call things. Then I realized that php tried to start an X session to try to start up rhythmbox because it couldn’t detect one. OK. Fine. Maybe I can try to use dbus to communicate with it? No dice. Linux mandates that users cannot see each others programs. Or at least I’ve failed at finding out how. I tried changing the uid,gid,eid through various languages, still to no avail.

Then I had a conversation with @xanderal and came up with the idea of a server running in user space listening for commands. Magical! I’ve been looking to try my hand at some node.js, so I figured this would be a great opportunity to try it out.

I found a great web server framework that would do handily (expressjs) for dealing with uri’s sent by ajax, and got it working in quick order.

###Gotchas

Because the port had to be different, I had to use jsonp to fetch data from the node.js server. What I couldn’t figure out is why sometimes the clicks sent out requests, and sometimes they didn’t. Browser caching is to blame. After setting $.ajax’s `cache` to false, it fired every time.

###Todos

I’d like to have autocompleted searching for songs and being able to play them.

Also I’d like to add in some volume controls too.

If there is any way possible to get this server to run in user space on startup (or more likely login) please let me know. That would be awesome

[1]: http://github.com/helloandre/playr
[2]: https:/twitter.com/xanderal
