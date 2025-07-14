export interface Job {
  title: string;
  city: string;
  jobType: 'full_time' | 'part_time' | 'internship' | 'contract' | string;
  minSalary: number;
  maxSalary: number;
  company: Company;
}

interface Company {
  name: string;
  slug: string;
}
