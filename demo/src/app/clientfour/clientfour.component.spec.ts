import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ClientfourComponent } from './clientfour.component';

describe('ClientfourComponent', () => {
  let component: ClientfourComponent;
  let fixture: ComponentFixture<ClientfourComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ClientfourComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ClientfourComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
