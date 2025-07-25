import { Component } from '@angular/core';
import { JobList } from '../job-list/job-list';
import { Navbar } from '../../features/navbar/navbar';
import { FormControl, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-find-job',
  imports: [Navbar, JobList, ReactiveFormsModule],
  templateUrl: './find-job.html',
  styleUrl: './find-job.css'
})
export class FindJob {

  searchTitle = new FormControl('')
  searchCity = new FormControl('')

  title = ''
  city = ''

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
