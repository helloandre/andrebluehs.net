---
layout: post
title: PHP and Security
---
Recently, I have been doing some work with php and having users log in. One of the projects I'm working on is something where we're pretty much rolling our own mini-CMS. We have users log in, manage sessions, check timeouts, etc. In php, security is pretty easy to do well (for my example... i'm being very general here). The rest of this post will skip over explaining how redirections and sessions work in php.

This is the easiest way to prevent someone who is not logged in from viewing the current page:

{% highlight php %}
if (!isset($_SESSION['user_id'])) header("Location: login.php");
{% endhighlight %}

What executes is if the user is not logged in (or has timed out and `$_SESSION['user_id']` has been `unset()`). Then the user is redirected to login.php or any appropriate page.

However, what happens when you run into something like an indexing or archiving bot that ignores headers? You run into [this tdwtf problem][1]. That article also tackles deletion-by-href instead of deletion-by-form. That's a whole different beast. What can you do about this problem? Is there a more secure alternative to using headers?

###Headers are just dandy###

What most people (including me up until recently) assume is that after sending the header, all things stop. For a bot, this is not the case, it goes on it's merry way executing the rest of the code. In the case of the above article, with dire consequences. But fret not! There is a simple solution.

{% highlight php %}
exit();
{% endhighlight %}

By putting `exit();` at the end of that line of code, the script stops executing, and while the bot may not be redirected, disaster is averted. So, your code will now look like:
    
{% highlight php %}
if (!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
{% endhighlight %}

Hope this helps stave off any disaster.

[1]: http://thedailywtf.com/Articles/WellIntentioned-Destruction.aspx
