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
    <pre>
    {
        "email" : "payette1996@gmail.com",
        "username" : "payette1996",
        "password" : "123",
        "firstname" : "Louis",
        "lastname" : "Payette"
    }
    </pre>

## PUT User
### 2 objects; 1: your email and password; 2: new desired details
URI : .../users/*
BODY : 
    <pre>
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        },
        "new": {
            "email" : "newEmail@email.com",
            "username" : "newUsername",
            "password" : "newPassword",
            "firstname" : "newFirstname",
            "lastname" : "newLastname"
        }
    }
    </pre>

## DELETE User
### Your email and password
URI : .../users/*
BODY : 
    <pre>
    {
        "email" : "payette1996@gmail.com",
        "password" : "123"
    }
    </pre>


## GET Thread Count
URI : .../threads
BODY : null

## GET Thread
URI : .../threads/*
BODY : null

## POST Thread
URI : .../threads
BODY : 
    <pre>
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        },
        "thread": {
            "title" : "My Thread Title",
            "description" : "My thread description"
        }
    }
    </pre>

## PUT Thread
### 3 objects; 1: your username and password; 2: thread ID; 3: newly desired content
URI : .../threads/*
BODY : 
    <pre>
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        },
        "thread": {
            "id" : 1
        },
        "new": {
            "title" : "New Title",
            "description" : "new description"
        }
    }
    </pre>


## DELETE Thread
### 2 objects; 1: your username and password; 2: thread ID
URI : .../threads/*
BODY : 
    <pre>
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        },
        "thread": {
            "id" : 1
        }
    }
    </pre>



## GET Post Count
URI : .../posts
BODY : null

## GET Post
URI : .../posts/*
BODY : null

## POST Post
URI : .../threads
BODY : 
    <pre>
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        },
        "post": {
            "title" : "My Post Title",
            "description" : "My post description",
            "threadId" : 1
        }
    }
    </pre>

## PUT Post
### 3 objects; 1: your username and password; 2: post ID; 3: newly desired content
URI : .../posts/*
BODY : 
    <pre>
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        },
        "post": {
            "id" : 1
        },
        "new": {
            "title" : "New Title",
            "description" : "new description"
        }
    }
    </pre>


## DELETE Post
### 2 objects; 1: your username and password; 2: post ID
URI : .../posts/*
BODY : 
    <pre>
    {
        "user": {
            "email" : "payette1996@gmail.com",
            "password" : "123"
        },
        "post": {
            "id" : 1
        }
    }
    </pre>