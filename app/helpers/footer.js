window.footer.userCount = document.querySelector("#userCount");
window.footer.threadCount = document.querySelector("#threadCount");
window.footer.postCount = document.querySelector("#postCount");

async function getCount(entity) {
    const response = await fetch(`/codelp/${entity}/count`, {
        headers: {"Cache-Control": "no-cache"}
    });
    if (response.ok) return await response.json();
};

getCount("users").then(count => window.footer.userCount.innerText = count);
getCount("threads").then(count => window.footer.threadCount.innerText = count);
getCount("posts").then(count => window.footer.postCount.innerText = count);