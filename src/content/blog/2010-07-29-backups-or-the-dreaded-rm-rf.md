---
title: Backups or rm -rf
pubDate: "2010-07-09"
slug: backups-or-the-dreaded-rm-rf
---

At my startup, we have a moderately sane deployment environment. Check-ins are automatically pushed to a staging server. When we want to push code to our live server, we manually move things.

For a while that meant we had to run a `svn export` command by hand once a day or so. (we are under heavy development still)

Eventually we needed a couple more things done when we moved code to the live server (among them run google's [closure compiler][4] to reduce our js footprint). So I wrote a script to handle these things. Apparently while testing, I got distracted and never finished it, because when i ran it, the code was this:

```bash
# ... snipped ...
#
# code to assure you're running as root
#

if [ -z $2 ]
then
loc= '/path/to/code'
else
$loc = $2
fi

# nuke old files
rm -rf $loc/\*
# ... snipped ...
```

Now, to the astute, you will notice there is a bug here. Can you find it? It's in the assignment of

```bash
$loc = $2
```

It SHOULD be similar to the loc assignment above it.

```bash
loc=$2
```

Well. This throws an error, but happily keeps moving on down the script. Next question: what happens here when `$loc` is an empty string `''`? That's right. **I just ran `rm -rf /*` as sudo on our main server.**

I [quickly realized](http://twitter.com/helloandre/status/19318926067) what had happened. Errors whizz by about permissions, and finally I Ctrl+c'd it out of existence. Everything still in memory was intact. Our application was still running, I was still ssh'd in. So I took stock of my life, and tried to calm down. I had no idea what to do at this point; thoughts ranged from spending the next 12 hours slowly rebuilding everything (I had the latest copy of our code and db on my local computer, so our code was safe) to never returning my CEO's emails again and abandoning our company. I initially did some fruitless googling for 'restore hard drive after rm' even though I knew - short of serious hard drive-level manipulation - I was NOT getting anything back.

Then I remembered that we are using [Jungle Disk](https://www.jungledisk.com/) to do daily and weekly backup. I figured out that our hosting allows us to reinstall our OS if something like... this happens. So first I checked that we had a recent backup. We did. So i went into our dasboard, and clicked on the button to 'Revert to Default'. [And waited](http://twitter.com/helloandre/status/19320699412). After that was done, the first thing I reinstalled was Jungle Disk and set it up to recognize itself. Then I simply ran Jungle Disk's restore program, and voilà! I installed a few more programs that we needed, and **we were 100% back up and running in about 3 hours**

We back up our /etc, /var, and /home folders daily and our entire file system weekly, so not too much data was lost. As it turns out, this doesn't include our Postfix maildir, so we lost about a week's worth of email (personally, I use gmail and it downloads all the email, so I didn't lose anything). We have since fixed this to save email daily.

This story is another among many to remind you to back your shit up. Fortunately we ended up ok; thanks in no small part to Jungle Disk.
