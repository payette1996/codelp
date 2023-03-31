window.nav.registerBtn = document.querySelector("#registerBtn");
window.nav.loginBtn = document.querySelector("#loginBtn");

window.nav.registerBtn.addEventListener("click", async () => {
    const registerView = await fetch("app/views/register.html", {
        headers: {"Cache-Control": "no-cache"}
    });
    if (registerView.ok) {
        view.call(window.main, "register");
    } else {
        console.log("Failed to fetch view.");
    }
});

window.nav.loginBtn.addEventListener("click", async () => {
    const loginView = await fetch("app/views/login.html", {
        headers: {"Cache-Control": "no-cache"}
    });
    if (loginView.ok) {
        view.call(window.main, "login");
    } else {
        console.log("Failed to fetch view.");
    }
});