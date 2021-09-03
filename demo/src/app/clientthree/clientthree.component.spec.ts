import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ClientthreeComponent } from './clientthree.component';

describe('ClientthreeComponent', () => {
  let component: ClientthreeComponent;
  let fixture: ComponentFixture<ClientthreeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ClientthreeComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ClientthreeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
