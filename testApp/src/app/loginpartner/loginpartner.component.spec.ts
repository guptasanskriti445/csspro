import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LoginpartnerComponent } from './loginpartner.component';

describe('LoginpartnerComponent', () => {
  let component: LoginpartnerComponent;
  let fixture: ComponentFixture<LoginpartnerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ LoginpartnerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(LoginpartnerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
