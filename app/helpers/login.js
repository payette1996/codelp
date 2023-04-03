window.main.loginForm = document.querySelector("#loginForm");
window.main.password = document.querySelector("#password");
window.main.errorSpan = document.querySelector("#errorSpan");

loginForm.addEventListener("submit", async event => {
    event.preventDefault();

    const formData = new FormData(loginForm);
    const formDataObject = {};
    formData.forEach((value, key) => {
      formDataObject[key] = value;
    });
    
    const response = await fetch("/codelp/auth", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formDataObject)
    });

    if (response.ok) {
        const responseJson = await response.json();
        if (responseJson.authenticated === true) {
            window.user = responseJson.user;
            view.call(window.nav, "nav");
            view.call(window.main, "main");
        } else {
            window.main.password.value = "";
            window.main.errorSpan.hidden = false;
        }
    }
});