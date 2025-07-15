import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { BehaviorSubject, catchError, firstValueFrom, of, tap } from 'rxjs';
import { User } from '../interfaces/UserInterface';

@Injectable({ providedIn: 'root' })
export class AuthService {
  private loggedIn$ = new BehaviorSubject<boolean>(false);
  private user$ = new BehaviorSubject<User | null>(null);

  constructor(private http: HttpClient) {}

  /** Call on app startup or after login/logout */
  initSession(): Promise<void> {
  return firstValueFrom(
    this.http.get('https://api.jobseeker.wip/api/me', {
      withCredentials: true,
      headers: new HttpHeaders({ Accept: 'application/ld+json, application/json' }),
    }).pipe(
      tap(user => {
        console.log('✅ initSession: user info', user);
        this.loggedIn$.next(true);
      }),
      catchError(err => {
        console.warn('❌ initSession: not logged in or parsing failed', err);
        this.loggedIn$.next(false);
        return of(null);
      }),
    )
  ).then(() => {});
}


  /** Synchronous: get current login state */
  isLoggedIn(): boolean {
    return this.loggedIn$.value;
  }

  /** Observable: watch login state changes */
  isLoggedIn$() {
    return this.loggedIn$.asObservable();
  }

  /** Observable: user info */
  getUser$() {
    return this.user$.asObservable();
  }

  /** Synchronous: current user */
  getCurrentUser(): User | null {
    return this.user$.value;
  }

 logout() {
    return this.http.post('https://api.jobseeker.wip/api/logout', {}, { withCredentials: true }).pipe(
      tap(() => {
        this.user$.next(null);
        this.loggedIn$.next(false);
        console.log('👋 User logged out');
      }),
      catchError(err => {
        console.error('Logout failed', err);
        return of(null);
      })
    );
  }

}
