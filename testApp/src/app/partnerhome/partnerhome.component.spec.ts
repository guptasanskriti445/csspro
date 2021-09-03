import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PartnerhomeComponent } from './partnerhome.component';

describe('PartnerhomeComponent', () => {
  let component: PartnerhomeComponent;
  let fixture: ComponentFixture<PartnerhomeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PartnerhomeComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PartnerhomeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
