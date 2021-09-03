import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ForwordpasswordComponent } from './forwordpassword.component';

describe('ForwordpasswordComponent', () => {
  let component: ForwordpasswordComponent;
  let fixture: ComponentFixture<ForwordpasswordComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ForwordpasswordComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ForwordpasswordComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
