window.main.usersUl = document.querySelector("#usersUl");
window.main.threadsUl = document.querySelector("#threadsUl");
window.main.threadForm = document.querySelector("#threadForm");

threadForm.hidden = !window.user;

async function getUsers() {
    const response = await fetch("/codelp/users");
    if (response.ok) return await response.json();
};

getUsers().then(users => {
    users.forEach(user => {
            window.main.usersUl.innerHTML += `<li id="${user.id}">${user.username}</li>`;
    });
});

async function getThreads() {
    const response = await fetch("/codelp/threads");
    if (response.ok) return await response.json();
};

getThreads().then(threads => {
    threads.forEach(thread => {
        window.main.threadsUl.innerHTML += `<li id="${thread.id}">${thread.title}</li>`;
    });
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
    }
});