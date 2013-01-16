---
title: Polite Javascript
date: 2012-05-22
layout: post
---
Let's say you're working with some legacy form submission javascript. You need to grab the value of the input with `id='email'` so you do something like:

    val = document.getElementById('email')
    console.log(val)

Printed to the console is the email you entered.

Next you try submitting the form, but to your dismay the client-side validation starts failing saying "Invalid Email Address". 

Wait, what?

You have just fallen victim to the consequences of two of the more severe violations of "polite javascript".

## The Bad

The first violation in the story there is some other variable in the validation script that uses `val` ([a horrible name for a variable](http://programmers.stackexchange.com/questions/138898/using-php-functions-reserved-words-as-local-identifiers/138999#138999)), and you just reassigned it to an invalid value.

This is how something like that happens:

    val = "hello";
    printme = function(){
        val = "world";
        return val;
    }
    console.log(printme()); // "world"
    console.log(val);       // "world"

## The Good

Javascript has a keyword `var` that declares a variable, but more importantly [the scope of a variable](https://developer.mozilla.org/en/JavaScript/Reference/Statements/var). This means that if you have two variables with the same name but one is global and the other is declared with `var` inside a function, they will not clobber each other.

Let's try the code from above using the `var` keyword:

    var val = "hello";
    var printme = function(){
        var val = "world";
        return val;
    }
    console.log(printme()); // "world"
    console.log(val);       // "hello"

## The second violation

You'll notice that in the example above the reason the first declaration of `val` doesn't change is because the second declaration is inside of a function. Using the `var` keyword alone wouldn't fix the problem outlined at the beginning, but putting different modules of code inside their own anonymous functions as well as using the keyword makes sure everyone's scope is correct.

Look at almost any sufficiently mature javascript library or plugin and you'll see that the entirety of it is wrapped inside an anonymous auto-executing function. [jQuery since 1.2](http://code.jquery.com/jquery-1.2.js) (the more recent jQuery's are in general a FANTASTIC example of well-written javascript), output from compiling [coffeescript](http://coffeescript.org/) and the list goes on.

## TL;DR

Wrap your code in an anonymous autoexecutin function:

    (function(){
        console.log('wheee');
    })();

Use the `var` keyword to assert the variable's scope.

    var date = '2012-05-22';