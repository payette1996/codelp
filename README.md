# Codelp
Codelp is a single page webapp forum



## GET User Count
URI : .../users
BODY : null

## GET User
URI : .../users/*
BODY : null

## POST User
URI : .../users/
BODY : 
    {
        "email" : "payette1996@gmail.com",
        "username" : "payette1996",
        "password" : "123",
        "firstname" : "Louis",
        "lastname" : "Payette"
    }

## PUT User
### 2 objects; 1: your email and password; 2: new desired details
URI : .../users/*
BODY : 
    {
        "user": {
            "id" : 1,
            "email" : "payette1996@gmail.com",
            "password" : "123"
        }
        "new: {
            "email" : "payette1996@gmail.com",
            "username" : "payette1996",
            "password" : "123",
            "firstname" : "Louis",
            "lastname" : "Payette"
        }
    }

## DELETE User
### Your email and password
URI : .../users/*
BODY : 
    {
        "email" : "payette1996@gmail.com",
        "password" : "123"
    }


## GET Thread Count
URI : .../threads
BODY : null

## GET Thread
URI : .../threads/*
BODY : null

## POST Thread
URI : .../threads
BODY : 
    {
        "title" : "My Thread Title",
        "description" : "My thread description",
        "userId" : 1
    }

## PUT Thread
### 3 objects; 1: your username and password; 2: thread ID; 3: newly desired content
URI : .../threads/*
BODY : 
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        }
        "thread": {
            "id" : 1
        }
        "new: {
            "title" : "New Title",
            "description" : "new description",
        }
    }


## DELETE Thread
### 2 objects; 1: your username and password; 2: thread ID
URI : .../threads/*
BODY : 
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        }
        "thread": {
            "id" : 1
        }
    }



## GET Post Count
URI : .../posts
BODY : null

## GET Post
URI : .../posts/*
BODY : null

## POST Post
URI : .../threads
BODY : 
    {
        "title" : "My Post Title",
        "description" : "My post description",
        "userId" : 1,
        "threadId" : 1
    }

## PUT Post
### 3 objects; 1: your username and password; 2: post ID; 3: newly desired content
URI : .../posts/*
BODY : 
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        }
        "post": {
            "id" : 1
        }
        "new: {
            "title" : "New Title",
            "description" : "new description",
        }
    }


## DELETE Post
### 2 objects; 1: your username and password; 2: post ID
URI : .../posts/*
BODY : 
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        }
        "post": {
            "id" : 1
        }
    }