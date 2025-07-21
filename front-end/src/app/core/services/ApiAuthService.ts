import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface AuthPayload {
  email: string;
  password: string;
}

export interface ResetRequestPayload {
  email: string;
}

export interface PasswordResetPayload {
  token: string;
  password: string;
}

export interface RegisterPayload {
  email: string
  plainPassword: string
  roles: ('ROLE_USER' | string)[];
  fullname: string
}

export interface AuthResponse {
  token?: string; // token optionnel, car tu récupères le cookie aussi
}

@Injectable({ providedIn: 'root' })
export class ApiAuthService {
  private readonly API_URL = 'https://api.jobseeker.wip';

  constructor(private http: HttpClient) {}

// 📥 get, fetch, load
  login(payload: AuthPayload): Observable<AuthResponse> {
    return this.http.post<AuthResponse>(
      `${this.API_URL}/auth`,
      payload,
      { withCredentials: true }  // ← Permet d'envoyer/recevoir les cookies
    );
  }

  register(payload: RegisterPayload): Observable<AuthResponse> {
    return this.http.post<AuthResponse>(
      // 💾 set, save, write
      `${this.API_URL}/api/users`,
      payload,
      { withCredentials: true,
        headers: {
          'Content-Type': 'application/ld+json',
          'Accept': 'application/ld+json' // optionnel mais recommandé
        }
      }
    );
  }

  requestReset(payload: ResetRequestPayload): Observable<void> {
    return this.http.post<void>(`${this.API_URL}/api/reset-password-request`, payload, {
      withCredentials: true,
    });
  }

  resetPassword(payload: PasswordResetPayload): Observable<void> {
    return this.http.post<void>(`${this.API_URL}/api/reset-password`, payload, {
      withCredentials: true,
    });
  }
}
