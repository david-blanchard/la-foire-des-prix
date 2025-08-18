class CookieManager {
  getCookie(name: string): string | null {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop()?.split(';').shift() || null;
    return null;
  }

  setCookie(name: string, value: string, days: number = 7): void {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = `${name}=${value}; expires=${expires}; path=/`;
  }

  deleteCookie(name: string): void {
    document.cookie = `${name}=; Max-Age=0; path=/`;
  }
}

function useCookie(): CookieManager {
  return new CookieManager();
}

export { useCookie };
