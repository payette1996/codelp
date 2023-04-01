window.main.usersUl = document.querySelector("#usersUl");
window.main.threadsUl = document.querySelector("#threadsUl");
window.main.postsUl = document.querySelector("#postsUl");

async function getUsers() {
    const response = await fetch("/codelp/users");
    if (response.ok) return await response.json();
};

getUsers().then(users => {
    users.forEach(user => {
            window.main.usersUl.innerHTML += `<li>${user.username}</li>`;
    });
});

async function getThreads() {
    const response = await fetch("/codelp/threads");
    if (response.ok) return await response.json();
};

getThreads().then(threads => {
    threads.forEach(thread => {
            window.main.threadsUl.innerHTML += `<li>${thread.title}</li>`;
    });
});

async function getPosts() {
    const response = await fetch("/codelp/posts");
    if (response.ok) return await response.json();
};

getPosts().then(posts => {
    posts.forEach(post => {
            window.main.postsUl.innerHTML += `<li>${post.title}</li>`;
    });
});