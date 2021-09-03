import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PartnermainComponent } from './partnermain.component';

describe('PartnermainComponent', () => {
  let component: PartnermainComponent;
  let fixture: ComponentFixture<PartnermainComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PartnermainComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PartnermainComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
