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
  private apiAuth = inject(ApiAuthService);
  private router = inject(Router);

  loginForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', Validators.required),
  });

  onSubmit(): void {
    console.log("pressed");
    if (this.loginForm.invalid) return;

    const { email, password } = this.loginForm.value;

    this.apiAuth.login({ email: email!, password: password! }).subscribe({
      next: (res) => {
        // console.log('Login response:', res);
        this.authService.setToken('');
        // console.log('Login successful');
        this.router.navigate(['/']);
      },
      error: (err) => {
        // console.error('Login failed:', err);
        alert('Invalid credentials');
      }
    });
  }
}
