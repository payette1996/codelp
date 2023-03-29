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
        "username" : "payetet1996",
        "password" : "123",
        "firstname" : "Louis",
        "lastname" : "Payette"
    }

## PUT User
### You must include at minimum the ID and the details to be changed
URI : .../users/*
BODY : 
    {
        "id" : 1,
        "email" : "payette1996@gmail.com",
        "username" : "payetet1996",
        "password" : "123",
        "firstname" : "Louis",
        "lastname" : "Payette"
    }

## DELETE User
### You must include the User ID
URI : .../users/*
BODY : 
    {
        "id" : 1
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
### You must include at minimum the ID and the details to be changed
URI : .../threads/*
BODY : 
    {
        "id" : 1,
        "title" : "My Thread Title",
        "description" : "My thread description",
    }

## DELETE Thread
### You must include the Thread ID
URI : .../threads/*
BODY : 
    {
        "id" : 1
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
### You must include at minimum the ID and the details to be changed
URI : .../posts/*
BODY : 
    {
        "id" : 1,
        "title" : "My Post Title",
        "description" : "My post description",
    }

## DELETE Post
### You must include the Thread ID
URI : .../posts/*
BODY : 
    {
        "id" : 1
    }
