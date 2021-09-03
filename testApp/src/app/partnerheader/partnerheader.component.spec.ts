import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PartnerheaderComponent } from './partnerheader.component';

describe('PartnerheaderComponent', () => {
  let component: PartnerheaderComponent;
  let fixture: ComponentFixture<PartnerheaderComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PartnerheaderComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PartnerheaderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
