import { Routes } from '@angular/router';
import { Home } from './pages/home/home';
import { Login } from './pages/login/login';
import { JobList } from './shared/components/job-list/job-list';

export const routes: Routes = [
  { path: '', component: Home },
  { path: 'login', component: Login },
  { path: 'jobs', component: JobList },
  { path: 'register', component: JobList },
];
