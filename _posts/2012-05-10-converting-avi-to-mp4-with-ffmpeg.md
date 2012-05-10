---
title: Converting AVI to MP4 with ffmpeg
date: 2012-05-10
---
I wanted to convert a file from AVI (mpeg2, mp3) to MP4 (mpeg4, aac) to be able to play it on another device (one without VLC). I found a 'helpful' post on how to [do this](http://www.catswhocode.com/blog/19-ffmpeg-commands-for-all-needs), but the commands were for a much much older (2008) version of ffmpeg. I then came across a [ubuntu forums post](http://ubuntuforums.org/showthread.php?t=1328537) that used the same commands but updated for the neweer (but still 2009) version of ffmpeg. After a little more fiddling, I finally found something that worked fantastic!

# Caveats:

 - I ran the below command on OSX with ffmpeg installed from homebrew. YMMV as far as codec availability goes.
 - I got up to ~200 frames per second on a Macbook Air with a 1.7 Gh i5, which took a 2.25 hour movie about 30 minutes to complete.

# TL;DR

### If you don't know what most or all of the below command means, you should probably read this entire post first.

If you've already got ffmpeg and an appropriate aac encoder, here's the ffmpeg command you'll need:

`ffmpeg -i input.avi -acodec libfaac -b:a 128k -vcodec mpeg4 -b:v 1200k -flags +aic+mv4 output.mp4`

# The long story

I ran the above command on a Macbook Air running OS X Lion 10.7.3 and installed ffmpeg and it's dependencies with [homebrew](http://mxcl.github.com/homebrew/). There were a couple steps to get to this point.

The following assumes you have homebrew installed and use the `brew` command.

## Installing ffmpeg

`brew install ffmpeg`

If you don't have `libogg` installed (which is likely) brew will choke and give you a couple more steps. It will probably tell you to run `brew link libogg`, and then the install command above again.

If you don't care much about how the actual ffmpeg command works, you can now run the below command (replacing 'input.avi' and 'output.mp4' with their respective values) and you're done.

`ffmpeg -i input.avi -acodec libfaac -b:a 128k -vcodec mpeg4 -b:v 1200k -flags +aic+mv4 output.mp4`

## ffmpeg command explained

I won't go into too much detail about the command, just some high points.

`acodec libfaac`

This uses the [faac](http://www.audiocoding.com/faac.html) codec to encode the audio to aac.

`-b:a 128k` and `-b:v 1200k`

These are the audio and video (respectively) bitrates of 128kb and 1200kb

`-flags +aic+mv4`

These options are explained in more detail [here](http://en.wikibooks.org/wiki/FFMPEG_An_Intermediate_Guide/Flags_Flags)

## Customizing

The beauty with using ffmpeg is that there are zillion options for customizing how your file is output. The most noticable things will be upping the audio and video bitrates, and using a better audio codec for aac. 