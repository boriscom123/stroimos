import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReportFilterFormComponent } from './report-filter-form.component';

describe('ReportFilterFormComponent', () => {
  let component: ReportFilterFormComponent;
  let fixture: ComponentFixture<ReportFilterFormComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReportFilterFormComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReportFilterFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
