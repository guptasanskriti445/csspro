import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ToproutesComponent } from './toproutes.component';

describe('ToproutesComponent', () => {
  let component: ToproutesComponent;
  let fixture: ComponentFixture<ToproutesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ToproutesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ToproutesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
