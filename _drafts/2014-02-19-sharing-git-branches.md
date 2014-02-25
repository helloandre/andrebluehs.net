---
title: Sharing Git Branches
date: 2013-08-19
layout: post
---
Let's start with a user story.

## The Problem

Your development team has a staging server. Management wants to see "alpha" versions of a new feature you're building[^foot1]. Now consider you don't want to "release" this feature by pushing it to either your staging or production servers. What can you do?

## The Possible Solutions

You have several options.

One option is that you can build a concept of "features" into your codebase that allow you to selectively control who can and cannot see codepaths. This is probably the most robust option as it scales well and affords all kinds of advantages like rolling out to a percentage of traffic.

Another option is you can do something similar as above but with filtering specifically by userid/username. This is a bit more hacky but works and also takes less time to implement.

The two options above necessitate a significant amount of forethought and careful manipulation of user data.

"But Wait!" you say, "I'm using Git! I can create branches to share things with people I don't want to show up on master!". 

Good job! Creating a branch and sharing this among other developers is a very easy, low-friction way of implementing a particular feature while not having to mess with production code.

However, what if the people you want to share this code don't[^foot2] have a development environment set up and/or access to the code?

## My Problem

I needed to be able to show non-technical[^foot3] people things that I have in a particular branch. 

My first thought was adding some kind of trigger to the staging environment to switch branches. That went out the window quickly due to the scary concept of conflicts happening. 

## My Solution

Then the lightbulb went on: "Why not have them all available in a subfolder[^foot4] on a special subdomain specifically for all the branches we have?".

I put together a script that runs on post-recieve that automatically clones any new branches, cleans up after delted ones[^foot5], and keeps any active branches (besides master) up to date on every push.

Now a flow can go something like: Hack on feature on branch "new-feature". Push code to git server. View on branches.example.com/new-feature/.

And any time code is pushed to "new-feature" it is automatically updated on branches.example.com/new-feature/

## Warnings

Woah, hey there, mister. This solution probably won't work for you. 

Why? It's colossally slow when first cloning a branch. It can eat up a ton of space on your server. It will probably break something url-based in your code.

With that said...
  
## The Code

Please know that this code is probably a really bad idea. Paritally because it has [a dreaded `rm -rf` in it][1]. But also because I haven't really tested it under heavy development yet.

    branches=()
    cleanbranches=()
    remote="refs/remotes/origin/"
    dest="/path/to/branches/"
    src="/path/to/main/code/"
    repo="git@git.example.com:repo.git"

    notin () {
        local e
        for e in "${@:2}"; do [[ "$e" == "$1" ]] && return 1; done
        return 0
    }

    cd "${src}"
    git remote prune origin
    eval "$(git for-each-ref --shell --format='branches+=(%(refname))' $remote)"

    cd "${dest}";
    for branch in "${branches[@]}"; do
        cleanbranch=`echo $branch | sed -e s%$remote%%g | sed -e s%/%-%g`;

        if [ "${cleanbranch}" != "master" ]; then
            cleanbranches+=($cleanbranch)

            if [ ! -d "${cleanbranch}" ]; then
                (git clone "${repo}" "${cleanbranch}" && cd "${cleanbranch}" && git checkout "${cleanbranch}")
            fi

            (cd "${cleanbranch}" && git pull origin "${cleanbranch}")
        fi
    done

    for dir in *; do
        if [[ "${dir}" != "." && "${dir}" != ".." ]]; then
            if notin "${dir}"  "${cleanbranches[@]}" ; then
                rm -rf "${dir}"
            fi
        fi
    done

Let me know if you have any other ideas for sharing prototypes of code that shouldn't be released, I'd love to hear any alternate solutions.

[^foot1]: Yes, this smacks of micromanagement, but there are legitimate times this may happen. Like for instance quickly prototyping things.

[^foot2]: And never will...

[^foot3]: And non-walking-over-to-my-desk-to-check-it-out-distance

[^foot4]: A subdomain would work equally as well. Probably better.

[^foot5]: Also works with `git push origin --delete branch`

[1]: http://andrebluehs.net/blog/backups-or-the-dreaded-rm-rf/