import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddtaxiComponent } from './addtaxi.component';

describe('AddtaxiComponent', () => {
  let component: AddtaxiComponent;
  let fixture: ComponentFixture<AddtaxiComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AddtaxiComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AddtaxiComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
