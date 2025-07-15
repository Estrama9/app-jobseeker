import { Component, inject } from '@angular/core';
import { FormGroup, FormControl, Validators, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../core/services/AuthService';
import { ApiAuthService } from '../../core/services/ApiAuthService';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink],
  templateUrl: './login.html',
  styleUrls: ['./login.css'],
})
export class Login {
  private authService = inject(AuthService);
  private apiAuthService = inject(ApiAuthService);
  private router = inject(Router);

  loginForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', Validators.required),
  });

  async onSubmit() {
    if (this.loginForm.invalid) return;

    const { email, password } = this.loginForm.value;

    this.apiAuthService.login({ email: email!, password: password! }).subscribe({
      next: async () => {
        await this.authService.initSession(); // ✅ Wait for session state
        this.router.navigate(['/']); // ✅ Guard now sees you're logged in
      },
      error: () => {
        alert('Invalid credentials');
      }
    });
  }
}
