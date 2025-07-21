import { Component, inject } from '@angular/core';
import { JobList } from '../../shared/components/job-list/job-list';
import { Navbar } from "../../features/navbar/navbar";
import { Router, RouterLink } from '@angular/router';
import { AuthService } from '../../core/services/AuthService';
import { AsyncPipe } from '@angular/common';

@Component({
  selector: 'app-home',
  imports: [Navbar, RouterLink, AsyncPipe],
  templateUrl: './home.html',
  styleUrl: './home.css'
})
export class Home {
  router = inject(Router);
  authService = inject(AuthService);
  loggedIn$ = this.authService.isLoggedIn$();

  logout() {
    this.authService.logout().subscribe(() => {
      this.router.navigate(['/login']);
    });
  }
}
