// export interface Job {
//   id: number
//   title: string;
//   city: string;
//   jobType: 'full_time' | 'part_time' | 'internship' | 'contract' | string;
//   minSalary: number;
//   maxSalary: number;
//   company: Company;
// }

// interface Company {
//   name: string;
//   slug: string;
// }


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
