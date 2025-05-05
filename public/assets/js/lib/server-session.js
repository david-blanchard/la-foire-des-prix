export default class ServerSession {

    #baseApiUrl = '/session';

    constructor(baseApiUrl) {
        this.#baseApiUrl = baseApiUrl;
    }

    retrieve(data, callback) {
        const context = this
        fetch(this.#baseApiUrl + "/retrieve", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (typeof callback === "function") {
                callback.call(context, data);
            }
        })
        .catch(error => console.error("Error:", error));
    }

    store(data, callback) {
        const context = this
        fetch(this.#baseApiUrl + "/store", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (typeof callback === "function") {
                callback.call(context, data);
            }
        })
        .catch(error => console.error("Error:", error));
    }
}
