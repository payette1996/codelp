window.nav.logo = document.querySelector("#logo");
window.nav.userSpan = document.querySelector("#userSpan");
window.nav.registerBtn = document.querySelector("#registerBtn");
window.nav.loginBtn = document.querySelector("#loginBtn");
window.nav.logoutBtn = document.querySelector("#logoutBtn");

window.nav.logo.addEventListener("click", () => {
    view.call(window.main, "main");
});

if (!window.user) {
    window.nav.userSpan.hidden = true;
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
} else {
    window.nav.userSpan.hidden = false;
    window.nav.registerBtn.hidden = true;
    window.nav.loginBtn.hidden = true;
    window.nav.logoutBtn.hidden = false;

    window.nav.userSpan.innerText = `Welcome, ${window.user.firstname}`;
    
    window.nav.logoutBtn.addEventListener("click", async () => {
        const response = await fetch("/codelp/session", { method: "POST" });
        window.user = null;
        view.call(window.nav, "nav");
        view.call(window.main, "main");
    });
}