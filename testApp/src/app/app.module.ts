import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { Title, Meta} from '@angular/platform-browser';
import { ReactiveFormsModule } from '@angular/forms';
import { JwtModule } from '@auth0/angular-jwt';
import { HttpClientModule } from '@angular/common/http';
import { ServicesService } from './services.service';


import { DatepickerModule, BsDatepickerModule} from 'ngx-bootstrap/datepicker';
// import { TimepickerModule } from 'ngx-bootstrap/timepicker';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './header/header.component';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { SelectionheaderComponent } from './selectionheader/selectionheader.component';
import { FooterComponent } from './footer/footer.component';
import { AboutusComponent } from './aboutus/aboutus.component';
import { SlidergalleryComponent } from './slidergallery/slidergallery.component';
import { ToproutesComponent } from './toproutes/toproutes.component';
import { TermsAndConditionComponent } from './terms-and-condition/terms-and-condition.component';
import { PrivacyPolicyComponent } from './privacy-policy/privacy-policy.component';
import { RefundPolicyComponent } from './refund-policy/refund-policy.component';
import { IndexComponent } from './index/index.component';
import { RegistrationformComponent } from './registrationform/registrationform.component';
import { ListingComponent } from './listing/listing.component';
import { LoginformComponent } from './loginform/loginform.component';
import { MybookingComponent } from './mybooking/mybooking.component';
import { ChangepasswordComponent } from './changepassword/changepassword.component';
import { ForwordpasswordComponent } from './forwordpassword/forwordpassword.component';
import { AddtaxiComponent } from './addtaxi/addtaxi.component';
import { AddpartnersComponent } from './addpartners/addpartners.component';
import { LoginpartnerComponent } from './loginpartner/loginpartner.component';
import { PartnerheaderComponent } from './partnerheader/partnerheader.component';
import { PartnermainComponent } from './partnermain/partnermain.component';
import { PartnerhomeComponent } from './partnerhome/partnerhome.component';
import { AdddriverComponent } from './adddriver/adddriver.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    SelectionheaderComponent,
    FooterComponent,
    AboutusComponent,
    SlidergalleryComponent,
    ToproutesComponent,
    TermsAndConditionComponent,
    PrivacyPolicyComponent,
    RefundPolicyComponent,
    IndexComponent,
    RegistrationformComponent,
    ListingComponent,
    LoginformComponent,
    MybookingComponent,
    ChangepasswordComponent,
    ForwordpasswordComponent,
    AddtaxiComponent,
    AddpartnersComponent,
    LoginpartnerComponent,
    PartnerheaderComponent,
    PartnermainComponent,
    PartnerhomeComponent,
    AdddriverComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    BrowserAnimationsModule,
    BsDatepickerModule.forRoot(),
    DatepickerModule.forRoot() ,
    // TimepickerModule.forRoot(),
    AppRoutingModule,
    FontAwesomeModule,
    ReactiveFormsModule,
    HttpClientModule,
    JwtModule.forRoot({
      config: {
        tokenGetter: function  tokenGetter() {
             return     localStorage.getItem('access_token');},
        // whitelistedDomains: ['localhost:4200'],
        // blacklistedRoutes: ['http://localhost:4200/auth/login']
      }
    })
  
    
  ],
  providers: [
    Title  ,
    Meta,
    ServicesService 
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
