import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { ApiAuthService } from '../../core/services/ApiAuthService';
import { requireOneOfTwo } from '../../core/validators/RoleValidator';
import { passwordMatchValidator } from '../../core/validators/PasswordMatchValidator';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-register',
  imports: [CommonModule, ReactiveFormsModule, RouterLink],
  templateUrl: './register.html',
  styleUrl: './register.css'
})
export class Register {

  private apiAuthService = inject(ApiAuthService);
  private router = inject(Router);

  loading = false;

  registerForm = new FormGroup({
    candidate: new FormControl<string | null>(null),
    employer: new FormControl<string | null>(null),
    fullname: new FormControl('', [Validators.required, Validators.minLength(3)]),
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', Validators.required),
    confirmPassword: new FormControl('', Validators.required),
}, {
  validators: [requireOneOfTwo('candidate', 'employer'), passwordMatchValidator]
});

  // 🧩 handle, process, manage
  async handleRegisterSubmit() {
    if (this.registerForm.invalid) return;

    const { candidate, employer, fullname, email, password } = this.registerForm.value;

    // Default role USER if none selected (adjust if needed)
    const roles = [];
    if (candidate) roles.push('ROLE_CANDIDATE');
    else if (employer) roles.push('ROLE_EMPLOYER');
    else roles.push('ROLE_USER');  // fallback

    this.loading = true;
    this.apiAuthService.register({
      email: email!,
      plainPassword: password!,
      roles,
      fullname: fullname!,
    }).subscribe({
      next: () => {
        this.loading = false;
        // 🔄 redirect
        this.router.navigate(['/login']);
      },
      error: (err) => {
        console.error('Registration error:', err);
        alert(err?.error?.detail || 'Une erreur est survenue pendant l’inscription.');
        this.loading = false;
      }
    });
  }

  get isCandidateSelected(): boolean {
    return this.registerForm.get('candidate')?.value === 'candidate';
  }

  selectCandidate(): void {
    this.registerForm.get('candidate')?.setValue('candidate');
    this.registerForm.get('employer')?.setValue(null);
  }

  get isEmployerSelected(): boolean {
    return this.registerForm.get('employer')?.value === 'employer';
  }

  selectEmployer(): void {
    this.registerForm.get('employer')?.setValue('employer');
    this.registerForm.get('candidate')?.setValue(null);
  }

  passwordVisible = false;
  confirmPasswordVisible = false;

}
