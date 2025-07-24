import { Component, inject } from '@angular/core';
import { JobService } from '../../core/services/job-service';
import { AsyncPipe } from '@angular/common';
import { Observable } from 'rxjs';
import { Job } from '../../core/interfaces/JobInterface';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-job-list',
  imports: [AsyncPipe, RouterLink],
  templateUrl: './job-list.html',
  styleUrl: './job-list.css'
})
export class JobList {

  private jobService = inject(JobService);

  jobs$: Observable<Job[]> = this.jobService.getJobs();
}




