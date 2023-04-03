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
                window.main.myProfileUl.innerHTML += `<strong>${key} : </strong>${value}<br>`;
            }
        }

        if (response.threads && response.threads.length > 0) {
            for (const thread of response.threads) {
                window.main.myThreadsUl.innerHTML += `
                    <label>
                        <input type="checkbox" name="thread[]" value=${thread.id}></input><br>
                        <strong>Title : </strong><br>${thread.title}<br>
                        <strong>Description : </strong><br>${thread.description}<br>
                        <strong>Created at : </strong><br>${thread.createdAt}<br>
                    </label><br>
                `;
            }
            window.main.myThreadsUl.innerHTML += "<input type='button' value='Delete thread(s)'>";
        }

        if (response.posts && response.posts.length > 0) {
            for (const post of response.posts) {
                window.main.myPostsUl.innerHTML += `
                    <label>
                        <input type="checkbox" name="thread[]" value=${post.id}></input><br>
                        <strong>Thread title : </strong><br>${post.threadTitle}<br>
                        <strong>Post title : </strong><br>${post.title}<br>
                        <strong>Post escription : </strong><br>${post.description}<br>
                        <strong>Post created at : </strong><br>${post.createdAt}<br>
                    </label><br>
                `;
            }
            window.main.myPostsUl.innerHTML += "<input type='button' value='Delete post(s)'>";
        }
    });