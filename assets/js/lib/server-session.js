import {useCookie} from "./cookieman.js";

export default class ServerSession {

    #baseApiUrl = '/session';
    #jwtCookieName = 'jwt';
    #jwtCookie = '';
    #baseHeaders = {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }

    constructor(baseApiUrl) {
        this.#baseApiUrl = '/api' + baseApiUrl;
        const cookie = useCookie();
        this.#jwtCookie = cookie.getCookie(this.#jwtCookieName);
        this.#baseHeaders.Authorization = "Bearer " + this.#jwtCookie;
    }

    retrieve(data, callback) {
        const context = this
        fetch(this.#baseApiUrl + "/retrieve", {
            method: "POST",
            headers: this.#baseHeaders,
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
            headers: this.#baseHeaders,
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
