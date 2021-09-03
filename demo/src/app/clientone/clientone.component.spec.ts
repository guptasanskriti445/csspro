import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ClientoneComponent } from './clientone.component';

describe('ClientoneComponent', () => {
  let component: ClientoneComponent;
  let fixture: ComponentFixture<ClientoneComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ClientoneComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ClientoneComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
