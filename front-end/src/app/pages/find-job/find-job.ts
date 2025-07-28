import { Component, effect, inject } from '@angular/core';
import { JobList } from '../job-list/job-list';
import { Navbar } from '../../features/navbar/navbar';
import { FormControl, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { JobSearchService } from '../../core/services/job-search-service';

@Component({
  selector: 'app-find-job',
  imports: [Navbar, JobList, ReactiveFormsModule],
  templateUrl: './find-job.html',
  styleUrl: './find-job.css'
})
export class FindJob {

  private jobSearch = inject(JobSearchService);

  selectedjob: string | null = null;

  searchTitle = new FormControl('')
  searchCity = new FormControl('')

  title = ''
  city = ''

  constructor(private route: ActivatedRoute) {

     effect(() => {
      const { title, city } = this.jobSearch.search();
      this.title = title;
      this.city = city;

      this.searchTitle.setValue(title);
      this.searchCity.setValue(city);
    });


    this.route.queryParamMap.subscribe(params => {
      this.selectedjob = params.get('job');
      console.log('Selected job:', this.selectedjob);

      // ✅ Update the form control with the param
      if (this.selectedjob) {
        this.searchTitle.setValue(this.selectedjob);
        this.title = this.selectedjob
      }
    });
  }

  OnSearchClick() {
    this.title = this.searchTitle.value || '';
    this.city = this.searchCity.value || '';
  }

  // searchValue = ''

  // ngOnInit() {
  //   this.searchControl.valueChanges.subscribe(val => {
  //     this.searchValue = val?.trim().toLowerCase() || '';
  //     console.log(val)
  //   });
  // }

}
