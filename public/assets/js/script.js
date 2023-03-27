window.head = document.querySelector("head");
window.script = document.querySelector("#currentScript")
window.nav = document.querySelector("nav");
window.main = document.querySelector("main");
window.footer = document.querySelector("footer");

async function view(view) {
    const fetchedView = await fetch(`app/views/${view}.html`, {
        headers: { 'Cache-Control': 'no-cache' }
    });

    const fetchedScript = await fetch(`app/helpers/${view}.js`, {
        headers: { 'Cache-Control': 'no-cache' }
    });

    if (fetchedView.ok && fetchedScript.ok) {
        this.innerHTML = await fetchedView.text();
        if (this.script) this.script.remove();
        this.script = document.createElement("script");
        this.script.defer = true;
        this.script.innerHTML = await fetchedScript.text();
        window.head.append(this.script);
    } else {
        console.log("Failed to fetch view.");
    }
}

view.call(window.nav, "nav");
view.call(window.main, "main");
view.call(window.footer, "footer");