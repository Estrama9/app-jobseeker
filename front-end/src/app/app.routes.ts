import { Routes } from '@angular/router';
import { Home } from './pages/home/home';
import { Login } from './pages/login/login';
import { JobList } from './shared/components/job-list/job-list';
import { Register } from './pages/register/register';
import { AuthGuard } from './core/guards/AuthGuard';
import { GuestGuard } from './core/guards/GuestGuard';

export const routes: Routes = [
  { path: '', component: Home, canActivate: [AuthGuard] },

  // Only allow guests (not logged in)
  {
  path: 'login', component : Login, canActivate: [GuestGuard],
},
  { path: 'register', component: Register, canActivate: [GuestGuard] },

  // Only allow authenticated users
  { path: 'jobs', component: JobList, canActivate: [AuthGuard] },

  // Optional: catch-all redirect to home
  { path: '**', redirectTo: '' },
];
