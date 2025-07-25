// core/services/job-service.ts
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Job } from '../interfaces/JobInterface';

interface ApiResponse<T> {
  member: T[];
  totalItems: number;
  // autres propriétés possibles...
}

@Injectable({ providedIn: 'root' })
export class JobService {
  private baseUrl = 'https://api.jobseeker.wip';

  constructor(private http: HttpClient) {}

  getJobs(): Observable<Job[]> {
  return this.http.get<ApiResponse<Job>>(`${this.baseUrl}/api/jobs`, {
    // withCredentials: true,
    headers: { accept: 'application/ld+json' }
  }).pipe(
    map(response => response.member) // Extract the array of jobs
  );
}

  getJob(id: number | string): Observable<Job> {
    return this.http.get<Job>(`${this.baseUrl}/api/jobs/${id}`, {
      withCredentials: true,
      headers: { accept: 'application/ld+json' }
    });
  }

  createJob(job: Partial<Job>): Observable<Job> {
    return this.http.post<Job>(`${this.baseUrl}/api/jobs`, job, {
      withCredentials: true,
      headers: {
        accept: 'application/ld+json',
        'Content-Type': 'application/json'
      }
    });
  }

  updateJob(id: number | string, job: Partial<Job>): Observable<Job> {
    return this.http.patch<Job>(`${this.baseUrl}/api/jobs/${id}`, job, {
      withCredentials: true,
      headers: {
        accept: 'application/ld+json',
        'Content-Type': 'application/json'
      }
    });
  }

  deleteJob(id: number | string): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/api/jobs/${id}`, {
      withCredentials: true,
      headers: { accept: 'application/ld+json' }
    });
  }
}
