// validators.ts
import { AbstractControl, ValidationErrors, ValidatorFn } from '@angular/forms';

export function requireOneOfTwo(candidate: string, employer: string): ValidatorFn {
  return (group: AbstractControl): ValidationErrors | null => {
    const formControl1 = group.get(candidate);
    const formControl2 = group.get(employer);
    if (!formControl1 || !formControl2) return null;

    const hasValue1 = !!formControl1.value?.toString().trim();
    const hasValue2 = !!formControl2.value?.toString().trim();

    return !hasValue1 && !hasValue2 ? { requireOne: true } : null;
  };
}
