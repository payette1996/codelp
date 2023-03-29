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
URI : .../users/*
BODY : 

## DELETE User
URI : .../users/*
BODY : 



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
        "title" : "My thread title",
        "description" : "My thread description",
        "userId" : 1
    }

## PUT Thread
URI : .../threads/*
BODY : 

## DELETE Thread
URI : .../threads/*
BODY : 



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
        "title" : "My post title",
        "description" : "My post description",
        "userId" : 1,
        "threadId" : 1
    }

## PUT Post
URI : .../threads/*
BODY : 

## DELETE Post
URI : .../threads/*
BODY : 