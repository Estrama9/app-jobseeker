import { Component, inject } from '@angular/core';
import { JobService } from '../../core/services/job-service';
import { Observable, switchMap } from 'rxjs';
import { Job } from '../../core/interfaces/JobInterface';
import { ActivatedRoute } from '@angular/router';
import { AsyncPipe } from '@angular/common';
import { Navbar } from '../../features/navbar/navbar';

@Component({
  selector: 'app-job-details',
  imports: [AsyncPipe, Navbar],
  templateUrl: './job-details.html',
  styleUrl: './job-details.css'
})
export class JobDetails {

  private route = inject(ActivatedRoute);
  private jobService = inject(JobService);

  job$: Observable<Job> = this.route.paramMap.pipe(
    switchMap(params => {
      const id = Number(params.get('id'));
      return this.jobService.getJob(id);
    })
  );
}
