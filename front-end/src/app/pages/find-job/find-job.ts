import { Component } from '@angular/core';
import { JobList } from '../job-list/job-list';
import { Navbar } from '../../features/navbar/navbar';

@Component({
  selector: 'app-find-job',
  imports: [Navbar, JobList],
  templateUrl: './find-job.html',
  styleUrl: './find-job.css'
})
export class FindJob {}
