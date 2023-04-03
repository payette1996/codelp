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
            for (const key in response["thread"]) {
                const value = response["thread"][key];
                window.main.threadUl.innerHTML += `${key} : ${value}<br>`;
            }
        }
        if (response["posts"]) {
            for (const post of response["posts"]) {
                for (const key in post) {
                    const value = post[key];
                    window.main.postsUl.innerHTML += `${key} : ${value}<br>`;
                }
                window.main.postsUl.innerHTML += "<br><hr><br>";
            }
        }
    });

postForm.addEventListener("submit", async event => {
    event.preventDefault();

    const formData = new FormData(postForm);
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