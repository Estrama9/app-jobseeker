import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root' })
export class AuthService {
  private readonly TOKEN_NAME = 'auth_token';

  getToken(): string | null {
    const match = document.cookie.match(new RegExp(`(^| )${this.TOKEN_NAME}=([^;]+)`));
    return match ? decodeURIComponent(match[2]) : null;
  }

  // Optional: to set the token (for login)
  setToken(token: string, days = 7): void {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = `${this.TOKEN_NAME}=${encodeURIComponent(token)}; expires=${expires}; path=/; Secure; SameSite=Lax`;
  }

  // Optional: to remove it (for logout)
  clearToken(): void {
    document.cookie = `${this.TOKEN_NAME}=; Max-Age=0; path=/; Secure; SameSite=Lax`;
  }

  isLoggedIn(): boolean {
    return !!this.getToken();
  }
}
