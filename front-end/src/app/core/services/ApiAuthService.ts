import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface AuthPayload {
  email: string;
  password: string;
}

export interface AuthResponse {
  token?: string; // token optionnel, car tu récupères le cookie aussi
}

@Injectable({ providedIn: 'root' })
export class ApiAuthService {
  private readonly API_URL = 'https://api.jobseeker.wip/auth';

  constructor(private http: HttpClient) {}

  login(payload: AuthPayload): Observable<AuthResponse> {
    return this.http.post<AuthResponse>(
      this.API_URL,
      payload,
      { withCredentials: true }  // ← Permet d'envoyer/recevoir les cookies
    );
  }
}
