import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ApiAuthService } from '../../../core/services/ApiAuthService';
import { RouterLink } from '@angular/router';
import { delay, dematerialize, materialize } from 'rxjs';

@Component({
  selector: 'app-reset-request',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './reset-request.html',
  styleUrl: './reset-request.css'
})
export class ResetRequest {

  private apiAuth = inject(ApiAuthService);

  success = false ;
  loading = false;
  error: string | null = null;

  form = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email])
  });


  handleResetRequestSubmit() {
    this.error = null;
    if (this.form.invalid) return;

    this.loading = true;
    this.apiAuth.requestReset({ email: this.form.value.email! })
    // 🔄 format, transform
    .pipe(
      materialize(),       // Turn next/error/complete into Notification objects
      delay(1000),         // Delay the notifications (including error)
      dematerialize())
    // 🧩 handle, process, manage
    .subscribe({
      next: () => {
        this.success = true;
        this.loading = false;
        setTimeout(() => {
          this.success = false;
      }, 5000);
    },
      error: (err) => {
        this.loading = false;
        this.error = 'An unexpected error occurred. Please try again.';
        setTimeout(() => {
          this.error = null;
        }, 5000);
      },
    });
  }
}
