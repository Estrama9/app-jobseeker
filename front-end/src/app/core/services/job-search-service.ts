import { computed, Injectable, signal } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class JobSearchService {

  title = signal<string>('')
  city = signal<string>('')

  setSearch(title: string, city: string) {
    this.title.set(title)
    this.city.set(city)
  }

  readonly search = computed(() => ({
    title: this.title().trim().toLowerCase(),
    city: this.city().trim().toLowerCase()
  }));

}
