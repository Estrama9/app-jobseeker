import { Component, inject } from '@angular/core';
import { JobService } from '../../../core/services/job-service';
import { AsyncPipe } from '@angular/common';
import { Observable } from 'rxjs';
import { Job } from '../../../core/interfaces/JobInterface';
import { Navbar } from '../../../features/navbar/navbar';

@Component({
  selector: 'app-job-list',
  imports: [AsyncPipe, Navbar],
  templateUrl: './job-list.html',
  styleUrl: './job-list.css'
})
export class JobList {

  jobs$: Observable<Job[]>;

  constructor(private jobService: JobService) {
  this.jobs$ = this.jobService.getJobs();
  this.jobs$.subscribe(data => console.log('Jobs received:', data));
}


  // private jobService = inject(JobService);

  // jobs$: Observable<Job[]> = this.jobService.getJobs();

}
