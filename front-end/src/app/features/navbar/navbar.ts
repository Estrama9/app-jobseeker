import { Component, inject } from '@angular/core';
import { NavigationEnd, Router, RouterLink } from '@angular/router';
import { AuthService } from '../../core/services/AuthService';
import { AsyncPipe } from '@angular/common';
import { filter } from 'rxjs';
import { FormControl, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-navbar',
  imports: [RouterLink, AsyncPipe, ReactiveFormsModule],
  templateUrl: './navbar.html',
  styleUrl: './navbar.css'
})
export class Navbar {

  router = inject(Router);
  authService = inject(AuthService);
  loggedIn$ = this.authService.isLoggedIn$();

  path = '';

  constructor() {
    this.router.events
      .pipe(filter(e => e instanceof NavigationEnd))
      .subscribe(() => {
        this.path = this.router.url.split('/')[1] || 'home';
      });
  }

  get currentRouteLabel(): string {
    const segment = this.router.url.split('/')[1] || 'home';
    return segment
      .split('-')                           // coupe par les "-"
      .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // majuscules
      .join(' ');
  }


  logout() {
    this.authService.logout().subscribe(() => {
      this.router.navigate(['/login']);
    });
  }

  user$ = this.authService.getUser$();


  dropdown1 = [
    {
      id: 0,
      isOpen: false,
      selectedUser: {
        id: 0,
        name: 'France',
        flag: '/france.png',
      },
      options: [
        { id: 0, name: 'France', flag: '/france.png' },
        { id: 1, name: 'Portugal', flag: '/portugal.png' }
      ]
    }
  ];

  dropdown2 = [
    {
      id: 0,
      isOpen: false,
      selectedUser: {
        id: 0,
        name: 'France',
        flag: '/france.png',
      },
      options: [
        { id: 0, name: 'France', flag: '/france.png' },
        { id: 1, name: 'Portugal', flag: '/portugal.png' }
      ]
    }
  ];


  toggleDropdown1() {
    this.dropdown1[0].isOpen = !this.dropdown1[0].isOpen;
  }

  toggleDropdown2() {
    this.dropdown2[0].isOpen = !this.dropdown2[0].isOpen;
  }

  selectUser1(user: any) {
    this.dropdown1[0].selectedUser = user;
    this.dropdown1[0].isOpen = false;
  }
  selectUser2(user: any) {
    this.dropdown2[0].selectedUser = user;
    this.dropdown2[0].isOpen = false;
  }

  searchTerm = new FormControl('');

  searchValue = ''


  ngOnInit() {
    if(this.path === "home") {
      this.searchTerm.valueChanges.subscribe(val => {
        this.searchValue = val?.trim().toLowerCase() || '';
      });
    }
  }

}
