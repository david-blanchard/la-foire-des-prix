class CookieManager {
    getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    setCookie(name, value, days = 7) {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = `${name}=${value}; expires=${expires}; path=/`;
    }

    deleteCookie(name) {
        document.cookie = `${name}=; Max-Age=0; path=/`;
    }
}

export function useCookie() {
    return new CookieManager();
}
