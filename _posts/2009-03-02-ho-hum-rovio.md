---
layout: post
title: Ho Hum Rovio
---
###UPDATE

It seems that Wowwee did things without telling us behind the scenes. According to their API, the encoders reset every time they are accessed. What they DIDN'T tell us is that the embeded os checks the encoders at 7hz. So our random findings with the encoders happened when we accedentally accessed the encoders in between when they were polling it. One solution is to just poll it faster (20hz seems to work). Wowwee is addressing this problem with some new firmware.

###/update

I am presently in a class called Robotics and Perception. This class is all about how robotics work and the underlying principles therein. We have discussed things ranging from motion to sensors to feature recognition. Our main project is making a little robot move around and do various things.

The robot we were given was a [Wowwee][2] [Rovio][3]. So far we have done some pretty [fun][4] [things][5] with it.

And then we needed to get accurate.

First, Rovio: A Quick Catch-Me-Up. Rovio is a "mobile web cam" that has a nice, pretty web interface for you to stare at whomever's shins you so choose. It also has an API (kinda) that you can use to develop your own commands and movement. This is just dandy if you are making a replacement web app or even an [iPhone app][1]. However, the way that you USE the API is with http requests. **You can control the rovio by going to a webpage**. Yikes. On the bright side, it's really damn simple to do. something like `wget http://192.168.10.18/rev.cgi?Cmd=nav&action=18&drive=1&speed=1` would make it drive forward a bit. Therein lies the problem.

This allows you no control over simple things like the motors. Or accurate movement. Or Even access to encoders. There is apparently a command to get an "MCU Report" that gives a string of 32 or so bits containing various information about encoders, positions, and whatnot. HOWEVER. Not a single group that is working on the Rovio with us can get the damn thing to work. Encoders that never change. Random numbers being given as positions. Inconsistent movements for the same command.

For instance. We have a command that rotates the Rovio 30 degrees. To accomplish this, we must move three times one way, then once back. Why? Because a side affect of only having a set number of commands that can be given at certain speeds means that there is a smallest one. Supposedly there are 10 speeds at which the Rovio can be rotated. However, nothing above 6 does anything. (larger = slower ...wtf?) The motors hum, but it goes nowhere, and the lowest speed that actually moves goes relatvely far (~22 degrees). So to go to 30 degrees, we must go 22 degrees 3 times, then come back 37 degrees (the next lowest speed).

This solution would be stellar, and perfectly acceptable if not for one thing: **this behavior is neither predictable nor consistent**. Sometimes the same command given goes too far, some times it doesn't go far enough. This is frustrating to say the least. When using the camera to check our bearing, it becomes much much easier. But for the time being, we are "dead reckoning" with something that is unpredictable.

Wish us luck.

[1]: http://gizmodo.com/5087686/wowwee-rovio-driver-app-now-available-for-the-iphone
[2]: http://www.wowwee.com/
[3]: http://www.meetrovio.com/
[4]: http://www.youtube.com/watch?v=_PFqwygGX8A
[5]: http://www.youtube.com/watch?v=6KwTwYuWgzc
