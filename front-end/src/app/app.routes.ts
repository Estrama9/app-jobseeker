import { Routes } from '@angular/router';
import { Home } from './pages/home/home';
import { Login } from './pages/login/login';
import { JobList } from './shared/components/job-list/job-list';
import { Register } from './pages/register/register';
import { AuthGuard } from './core/guards/AuthGuard';
import { GuestGuard } from './core/guards/GuestGuard';
import { ResetPassword } from './shared/components/reset-password/reset-password';
import { ResetRequest } from './shared/components/reset-request/reset-request';

export const routes: Routes = [
  // { path: '', component: Home, canActivate: [AuthGuard] },
  { path: '', component: Home },

  // Only allow guests (not logged in)
  {
  path: 'login', component : Login, canActivate: [GuestGuard] },

  { path: 'register', component: Register, canActivate: [GuestGuard] },

  // { path: 'resetPassword', component: ResetPassword, canActivate: [GuestGuard] },

  { path: 'reset-password-request', component: ResetRequest, canActivate: [GuestGuard] },

  { path: 'reset-password', component: ResetPassword, canActivate: [GuestGuard] },

  // Only allow authenticated users
  { path: 'jobs', component: JobList, canActivate: [AuthGuard] },

  // Optional: catch-all redirect to home
  { path: '**', redirectTo: '' },
];
