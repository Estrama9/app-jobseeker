import { Routes } from '@angular/router';
import { Home } from './pages/home/home';
import { Login } from './pages/login/login';
import { JobList } from './pages/job-list/job-list';
import { Register } from './pages/register/register';
import { AuthGuard } from './core/guards/AuthGuard';
import { GuestGuard } from './core/guards/GuestGuard';
import { ResetPassword } from './pages/reset-password/reset-password';
import { ResetRequest } from './pages/reset-request/reset-request';
import { FindJob } from './pages/find-job/find-job';
import { JobDetails } from './pages/job-details/job-details';

export const routes: Routes = [
  // { path: '', component: Home, canActivate: [AuthGuard] },
  { path: '', component: Home },

  { path: 'find-job', component: FindJob },

  // Only allow authenticated users
  { path: 'jobs', component: JobList, canActivate: [AuthGuard] },

  { path: 'jobs/:id', component: JobDetails, canActivate: [AuthGuard] },

  // Only allow guests (not logged in)
  {
  path: 'login', component : Login, canActivate: [GuestGuard] },

  { path: 'register', component: Register, canActivate: [GuestGuard] },

  // { path: 'resetPassword', component: ResetPassword, canActivate: [GuestGuard] },

  { path: 'reset-password-request', component: ResetRequest, canActivate: [GuestGuard] },

  { path: 'reset-password', component: ResetPassword, canActivate: [GuestGuard] },

  // Optional: catch-all redirect to home
  { path: '**', redirectTo: '' },
];
