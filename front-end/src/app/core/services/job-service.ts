// src/app/services/job.service.ts
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Job } from '../interfaces/JobInterface';

@Injectable({ providedIn: 'root' })
export class JobService {
  private baseUrl = 'http://api.jobseeker.wip:8000';

  constructor(private http: HttpClient) {}

  getJobs(): Observable<Job[]> {
    return this.http.get<Job[]>(`${this.baseUrl}/api/jobs`);
  }

  getJob(id: number | string): Observable<Job> {
    return this.http.get<Job>(`${this.baseUrl}/api/jobs/${id}`);
  }

  createJob(job: Partial<Job>): Observable<Job> {
    return this.http.post<Job>(`${this.baseUrl}/api/jobs`, job);
  }

  updateJob(id: number | string, job: Partial<Job>): Observable<Job> {
    return this.http.patch<Job>(`${this.baseUrl}/api/jobs/${id}`, job);
  }

  deleteJob(id: number | string): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/api/jobs/${id}`);
  }
}
