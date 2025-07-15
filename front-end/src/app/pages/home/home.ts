import { Component } from '@angular/core';
import { JobList } from '../../shared/components/job-list/job-list';
import { Navbar } from "../../features/navbar/navbar";

@Component({
  selector: 'app-home',
  imports: [Navbar],
  templateUrl: './home.html',
  styleUrl: './home.css'
})
export class Home {

}
