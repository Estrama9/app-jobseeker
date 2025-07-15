import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { Observable, map, take, tap } from 'rxjs';
import { AuthService } from '../services/AuthService';

@Injectable({ providedIn: 'root' })
export class GuestGuard implements CanActivate {
  constructor(private auth: AuthService, private router: Router) {}

  canActivate(): Observable<boolean> {
    return this.auth.isLoggedIn$().pipe(
      take(1),
      tap(() => console.log('👀 GuestGuard checking login state...')),
      map(isLoggedIn => {
        if (isLoggedIn) {
          this.router.navigate(['/']); // Redirect if logged in
          return false;
        }
        return true;
      })
    );
  }
}
