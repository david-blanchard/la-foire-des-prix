import { useCookie } from './CookieManager';

type Callback = (data: any) => void;

class ServerSession {
  private baseApiUrl: string = '/session';
  private jwtCookieName: string = 'jwt';
  private jwtCookie: string = '';
  private baseHeaders: Record<string, string> = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN':
      document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content') || '',
  };

  constructor(baseApiUrl: string) {
    this.baseApiUrl = '/api' + baseApiUrl;
    const cookie = useCookie();
    this.jwtCookie = cookie.getCookie(this.jwtCookieName) ?? '';
    this.baseHeaders.Authorization = 'Bearer ' + this.jwtCookie;
  }

  retrieve(data: any, callback?: Callback): void {
    const context = this;
    fetch(this.baseApiUrl + '/retrieve', {
      method: 'POST',
      headers: this.baseHeaders,
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((data) => {
        if (typeof callback === 'function') {
          callback.call(context, data);
        }
      })
      .catch((error) => console.error('Error:', error));
  }

  store(data: any, callback?: Callback): void {
    const context = this;
    fetch(this.baseApiUrl + '/store', {
      method: 'POST',
      headers: this.baseHeaders,
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((data) => {
        if (typeof callback === 'function') {
          callback.call(context, data);
        }
      })
      .catch((error) => console.error('Error:', error));
  }
}

export function useServerSession(route: string): ServerSession {
  return new ServerSession(route);
}
