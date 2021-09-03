import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SelectionheaderComponent } from './selectionheader.component';

describe('SelectionheaderComponent', () => {
  let component: SelectionheaderComponent;
  let fixture: ComponentFixture<SelectionheaderComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SelectionheaderComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(SelectionheaderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
