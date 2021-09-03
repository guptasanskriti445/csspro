import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { AdminGuard } from './admin/admin.guard';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ClientoneComponent } from './clientone/clientone.component';
import { ClienttwoComponent } from './clienttwo/clienttwo.component';
import { ClientthreeComponent } from './clientthree/clientthree.component';
import { ClientfourComponent } from './clientfour/clientfour.component';
import { FooterComponent } from './footer/footer.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    DashboardComponent,
    ClientoneComponent,
    ClienttwoComponent,
    ClientthreeComponent,
    ClientfourComponent,
    FooterComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule
  ],
  providers: [AdminGuard],
  bootstrap: [AppComponent]
})
export class AppModule { }
{ }
