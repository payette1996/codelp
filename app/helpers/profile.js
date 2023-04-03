window.main.myProfileUl = document.querySelector("#myProfileUl");
window.main.myThreadsUl = document.querySelector("#myThreadsUl");
window.main.myPostsUl = document.querySelector("#myPostsUl");

async function getUser() {
    const response = await fetch(`/codelp/users/${window.user.id}`, {
        headers: {"Cache-Control": "no-cache"}
    });
    if (response.ok) return await response.json();
}

getUser()
    .then(response => {
        if (response.user) {
            for (const key in response.user) {
                const value = response.user[key];
                window.main.myProfileUl.innerHTML += `${key} : ${value}<br>`;
            }
        }

        if (response.threads && response.threads.length > 0) {
            for (const thread of response.threads) {
                for (const key in thread) {
                    const value = thread[key];
                    window.main.myThreadsUl.innerHTML += `${key} : ${value}<br>`;
                }
                window.main.myThreadsUl.innerHTML += "<br>";
            }
        }

        if (response.posts && response.posts.length > 0) {
            for (const post in response.Posts) {
                for (const key in post) {
                    const value = post[key];
                    window.main.myPostsUl.innerHTML += `${key} : ${value}<br>`;
                }
                window.main.myPostsUl.innerHTML += "<br>";
            }
        }
    });