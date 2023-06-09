window.main.usersUl = document.querySelector("#usersUl");
window.main.threadsUl = document.querySelector("#threadsUl");
window.main.threadForm = document.querySelector("#threadForm");

threadForm.hidden = !window.user;

async function getUsers() {
    const response = await fetch("/codelp/users", {
        headers: {"Cache-Control": "no-cache"}
    });
    if (response.ok) return await response.json();
};

getUsers()
    .then(users => {
        users.forEach(user => {
            window.main.usersUl.innerHTML += `<li class="text-link" data-user-id="${user.id}">${user.username}</li>`;
        });
    })
    .then(() => {
        window.main.usersList = window.main.usersUl.querySelectorAll("li");

        for (const user of window.main.usersList) {
            user.addEventListener("click", function() {
                window.userId = this.getAttribute("data-user-id");
                view.call(window.main, "user");
            });
        }
    });

async function getThreads() {
    const response = await fetch("/codelp/threads", {
        headers: {"Cache-Control": "no-cache"}
    });
    if (response.ok) return await response.json();
};

getThreads()
    .then(threads => {
        threads.forEach(thread => {
            window.main.threadsUl.innerHTML += `<li class="text-link" data-thread-id="${thread.id}">${thread.title}</li>`;
        });
    })
    .then(() => {
        window.main.threadsList = window.main.threadsUl.querySelectorAll("li");

        for (const thread of window.main.threadsList) {
            thread.addEventListener("click", function() {
                window.threadId = this.getAttribute("data-thread-id");
                view.call(window.main, "thread");
            });
        }
    });

threadForm.addEventListener("submit", async event => {
    event.preventDefault();

    const formData = new FormData(threadForm);
    const formDataObject = {};
    formData.forEach((value, key) => {
      formDataObject[key] = value;
    });
    
    const response = await fetch("/codelp/threads", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formDataObject)
    });

    if (response.ok) {
        const responseJson = await response.json();
        if (responseJson) {
            view.call(window.main, "main");
            view.call(window.footer, "footer");
        } else {
            console.log("An error occured during thread post");
        }
    } else {
        console.log(await response.text());
    }
});