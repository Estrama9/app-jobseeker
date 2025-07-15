import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { Router } from '@angular/router';

@Component({
  selector: 'app-navbar',
  imports: [RouterLink],
  templateUrl: './navbar.html',
  styleUrl: './navbar.css'
})
export class Navbar {
  constructor(private router: Router) {}

  logout() {
    // Clear authentication state (example with localStorage)
    localStorage.removeItem('token'); // Or whatever key you use
    this.router.navigate(['/login']);
  }
}
