window.main.myProfileUl = document.querySelector("#myProfileUl");
window.main.myThreadsUl = document.querySelector("#myThreadsUl");
window.main.myPostsUl = document.querySelector("#myPostsUl");

async function getMyThreads() {
    const response = await fetch("/codelp/threads");
    if (response.ok) return await response.json();
}

async function getMyPosts() {
    const response = await fetch("/codelp/posts");
    if (response.ok) return await response.json();
}

for (const key in window.user) {
    const value = window.user[key];
    window.main.myProfileUl.innerHTML += `${key} : ${value}<br>`;
}