import { Component, inject } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ApiAuthService } from '../../../core/services/ApiAuthService';
import { passwordMatchValidator } from '../../../core/validators/PasswordMatchValidator';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-reset-password',
  imports: [CommonModule, ReactiveFormsModule, RouterLink],
  templateUrl: './reset-password.html',
  styleUrl: './reset-password.css'
})
export class ResetPassword {

  private route = inject(ActivatedRoute);
  private apiAuth = inject(ApiAuthService);
  private router = inject(Router);
  private fb = inject(FormBuilder);

  token: string | null = this.route.snapshot.queryParamMap.get('token');

  success = false;
  loading = false;
  error: string | null = null;

  form: FormGroup = this.fb.group({
    password: ['', [Validators.required, Validators.minLength(6)]],
    confirmPassword: ['', [Validators.required, Validators.minLength(6)]],
  }, {
    validators: [passwordMatchValidator]
  });

  // ✅ handle form submit
  onSubmit() {
    if (!this.token) {
      this.error = 'The link is invalid or has expired.';
      setTimeout(() => {
          this.error = null;
        }, 5000);
      return;
    }

    if (this.form.invalid) return;

    this.loading = true;

    this.apiAuth
      .resetPassword({ token: this.token, password: this.form.value.password! })
      .subscribe({
        next: () => {
          this.success = true;
          this.loading = false;
          setTimeout(() => {
            this.success = false;
            this.router.navigate(['/login']);
          }, 5000);

        },
        error: () => {
          this.error = 'The link is invalid or has expired.';
          setTimeout(() => {
            this.error = null;
          }, 5000);
          this.loading = false;
        },
      });
  }

  passwordVisible = false;
  confirmPasswordVisible = false;
}
