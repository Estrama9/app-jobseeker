import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ResetRequest } from './reset-request';

describe('ResetRequest', () => {
  let component: ResetRequest;
  let fixture: ComponentFixture<ResetRequest>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ResetRequest]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ResetRequest);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
