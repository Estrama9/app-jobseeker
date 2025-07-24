import { Component, inject } from '@angular/core';
import { Navbar } from "../../features/navbar/navbar";
import { Router, RouterLink } from '@angular/router';
import { AuthService } from '../../core/services/AuthService';
import { AsyncPipe } from '@angular/common';
import { FindJob } from '../find-job/find-job';
import { JobList } from "../job-list/job-list";

@Component({
  selector: 'app-home',
  imports: [Navbar],
  templateUrl: './home.html',
  styleUrl: './home.css'
})
export class Home {}
