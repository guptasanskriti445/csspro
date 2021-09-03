import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddpartnersComponent } from './addpartners.component';

describe('AddpartnersComponent', () => {
  let component: AddpartnersComponent;
  let fixture: ComponentFixture<AddpartnersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AddpartnersComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AddpartnersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
