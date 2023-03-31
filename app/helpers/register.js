window.main.registerForm = document.querySelector("#registerForm");

registerForm.addEventListener("submit", async event => {
    event.preventDefault();

    const formData = new FormData(registerForm);
    const formDataObject = {};
    formData.forEach((value, key) => {
      formDataObject[key] = value;
    });
    
    const response = await fetch("/codelp/users", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formDataObject)
    });

    if (response.ok) {
        const responseJson = await response.json();
        console.log(responseJson);
        if (responseJson) {
            view.call(window.main, "login");
            view.call(window.footer, "footer");
        } else {
            console.log("An error occured during registration");
        }
    }
});