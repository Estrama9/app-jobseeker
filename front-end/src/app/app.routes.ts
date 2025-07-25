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
  // Home route with static breadcrumb label
  { path: '', component: Home, data: { breadcrumb: 'Home' } },

  // Find Job route with static breadcrumb label
  { path: 'find-job', component: FindJob, data: { breadcrumb: 'Find Job' } },

  // Jobs list route (only for authenticated users in a real app)
  { path: 'jobs', component: JobList, canActivate: [AuthGuard], data: { breadcrumb: 'Jobs' } },

  // Job details route with a resolver for dynamic breadcrumb label
  { path: 'jobs/:id', component: JobDetails, canActivate: [AuthGuard]},

  // Authentication routes (only for guests in a real app)
  { path: 'login', component: Login, canActivate: [GuestGuard], data: { breadcrumb: 'Login' } },
  { path: 'register', component: Register, canActivate: [GuestGuard], data: { breadcrumb: 'Register' } },
  { path: 'reset-password-request', component: ResetRequest, canActivate: [GuestGuard], data: { breadcrumb: 'Reset Password Request' } },
  { path: 'reset-password', component: ResetPassword, canActivate: [GuestGuard], data: { breadcrumb: 'Reset Password' } },

  // Catch-all redirect to home for any unmatched routes
  { path: '**', redirectTo: '' },
];
