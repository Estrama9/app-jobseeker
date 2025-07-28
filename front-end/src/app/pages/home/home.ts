import { Component, inject, input, output } from '@angular/core';
import { Navbar } from "../../features/navbar/navbar";
import { Router, RouterLink } from '@angular/router';
import { FormControl, ReactiveFormsModule } from '@angular/forms';
import { JobSearchService } from '../../core/services/job-search-service';

@Component({
  selector: 'app-home',
  imports: [Navbar, RouterLink, ReactiveFormsModule],
  templateUrl: './home.html',
  styleUrl: './home.css'
})
export class Home {

  private jobSearch = inject(JobSearchService)
  private router = inject(Router)

  searchTitle = new FormControl('')
  searchCity = new FormControl('')

  title = ''
  city = ''

  onSearchClick() {
    this.title = this.searchTitle.value || ''
    this.city = this.searchCity.value || ''
    this.jobSearch.setSearch(this.title, this.city)
    this.router.navigate(['/find-job']);
    console.log(this.jobSearch)
  }
}
