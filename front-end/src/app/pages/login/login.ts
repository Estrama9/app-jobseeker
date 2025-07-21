import { Component, inject } from '@angular/core';
import { FormGroup, FormControl, Validators, ReactiveFormsModule } from '@angular/forms';
import { AsyncPipe, CommonModule } from '@angular/common';
import { AuthService } from '../../core/services/AuthService';
import { ApiAuthService } from '../../core/services/ApiAuthService';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink,AsyncPipe],
  templateUrl: './login.html',
  styleUrls: ['./login.css'],
})
export class Login {
  private authService = inject(AuthService);
  private apiAuthService = inject(ApiAuthService);
  private router = inject(Router);

  success = false;
  loading = false;
  error: string | null = null;

  user$ = this.authService.getUser$();

  loginForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', Validators.required),
  });

  async handleLoginSubmit() {
    if (this.loginForm.invalid) return;

    const { email, password } = this.loginForm.value;
    this.loading = true;
    this.apiAuthService.login({ email: email!, password: password!})
    // 🧩 handle, process, manage
    .subscribe({
      next: async () => {
        await this.authService.loadCurrentUser();
        this.loading = false;
        this.success = true;
        setTimeout(() => {
          this.success = false;
            // 🔄 redirect
          this.router.navigate(['/']); // ✅ Guard now sees you're logged in
        }, 2000);
      },
      error: () => {
        // alert('Invalid credentials');
        this.loading = false;
        this.error = 'Invalid Credentials, Please try again.'
        setTimeout(() => {
            this.error = null;
        }, 5000);
      }
    });
  }

  passwordVisible = false;
  confirmPasswordVisible = false;
}
