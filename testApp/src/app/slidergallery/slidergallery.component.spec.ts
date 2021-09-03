import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SlidergalleryComponent } from './slidergallery.component';

describe('SlidergalleryComponent', () => {
  let component: SlidergalleryComponent;
  let fixture: ComponentFixture<SlidergalleryComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SlidergalleryComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(SlidergalleryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
