export interface Company {
  '@id': string;
  '@type': string;
  name: string;
  slug: string;
}

export interface Job {
  '@id': string;
  '@type': string;
  id: number;
  title: string;
  city: string;
  jobType: string;
  minSalary: number;
  maxSalary: number;
  company: Company;
}
