import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ClienttwoComponent } from './clienttwo.component';

describe('ClienttwoComponent', () => {
  let component: ClienttwoComponent;
  let fixture: ComponentFixture<ClienttwoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ClienttwoComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ClienttwoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
