window.main.threadUl = document.querySelector("#threadUl");
window.main.postsUl = document.querySelector("#postsUl");
window.main.postForm = document.querySelector("#postForm");

async function getThread(id) {
    const response = await fetch(`/codelp/threads/${id}`, {
        headers: {"Cache-Control": "no-cache"}
    });
    if (response.ok) return await response.json();
};

getThread(window.threadId)
.then(response => {
        if (response["thread"]) {
            const thread = response["thread"];
            window.main.threadUl.innerHTML += `
                <strong>Title:</strong><br>${thread.title}<br>
                <strong>Description:</strong><br>${thread.description}<br>
                <strong>Username:</strong><br>${thread.username}<br>
                <strong>Created at:</strong><br>${thread.createdAt}<br>
            `;
        }
        if (response["posts"]) {
            for (const post of response["posts"]) {
                window.main.postsUl.innerHTML += `
                    <strong>Title:</strong><br>${post.title}<br>
                    <strong>Description:</strong><br>${post.description}<br>
                    <strong>Username:</strong><br>${post.username}<br>
                    <strong>Created at:</strong><br>${post.createdAt}<br></br>
                `;
                window.main.postsUl.innerHTML += "<hr><br>";
            }
        }
    });

postForm.addEventListener("submit", async event => {
    event.preventDefault();

    const formData = new FormData(postForm);
    formData.append("threadId", window.threadId);
    const formDataObject = {};
    formData.forEach((value, key) => {
        formDataObject[key] = value;
    });

    const response = await fetch("/codelp/posts", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formDataObject)
    });

    if (response.ok) {
        const responseJson = await response.json();
        if (responseJson) {
            view.call(window.main, "thread");
            view.call(window.footer, "footer");
        } else {
            console.log("An error occured during post post");
        }
    } else {
        console.log(await response.text());
    }
});