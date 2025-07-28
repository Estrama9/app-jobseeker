import { Component, effect, inject, input, OnChanges } from '@angular/core';
import { JobService } from '../../core/services/job-service';
import { AsyncPipe } from '@angular/common';
import { BehaviorSubject, catchError, debounceTime, distinctUntilChanged, finalize, map, Observable, of, startWith, switchMap, tap } from 'rxjs';
import { Job } from '../../core/interfaces/JobInterface';
import { RouterLink } from '@angular/router';


@Component({
  selector: 'app-job-list',
  imports: [AsyncPipe, RouterLink],
  templateUrl: './job-list.html',
  styleUrl: './job-list.css'
})

export class JobList implements OnChanges {
  private jobService = inject(JobService);
  // private jobSearch = inject(JobSearchService);

  searchTitle = input<string>('');
  searchCity = input<string>('');

  private searchTerms$ = new BehaviorSubject<{ title: string; city: string }>({ title: '', city: 'lille' });
  private _error = new BehaviorSubject<string | null>(null);
  private _isLoading = new BehaviorSubject<boolean>(false); // New BehaviorSubject for loading state

  readonly error$ = this._error.asObservable();
  readonly isLoading$ = this._isLoading.asObservable(); // Expose loading state

  jobs$: Observable<Job[]> = this.searchTerms$.pipe(
    debounceTime(300),
    distinctUntilChanged((prev, curr) => prev.title === curr.title && prev.city === curr.city),
    startWith({title: '' , city: 'lille'}), //for exemple city: 'paris '
    switchMap(({ title, city }) =>
      this.jobService.getJobs().pipe(
        // --- LOADING INDICATOR ADDED (Start) ---
        tap(() => {
          this._isLoading.next(true); // Set loading to true when API call starts
          this._error.next(null); // Clear errors when a new search begins
          console.log(this._isLoading)
          console.log(this.searchTerms$.value, 'tap')
        }),
        map(jobs => {
          return jobs.filter(job =>
            job.title.toLowerCase().includes(title) &&
            job.city.toLowerCase().includes(city)
          )
        }),
        catchError(err => {
          console.error('Error fetching jobs:', err);
          this._error.next('Failed to load jobs. Please try again later.');
          return of([]);
        }),
        // --- LOADING INDICATOR ADDED (End) ---
        finalize(() => {
          this._isLoading.next(false); // Set loading to false when API call completes (success or error)
        })
      )
    )
  );

  ngOnChanges(): void {
  const title = this.searchTitle()?.trim().toLowerCase() || '';
  const city = this.searchCity()?.trim().toLowerCase() || '';
  this.searchTerms$.next({ title, city });
  // console.log(this.searchTerms$.value, 'ng-apres-next')
  }

  // constructor() {
  //   effect(() => {
  //     const { title, city } = this.jobSearch.search();
  //     this.searchTerms$.next({ title, city });
  //     console.log(this.searchTerms$.value)
  //   });
  // }
}
