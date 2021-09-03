import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { IndexComponent } from './index/index.component';
import { TermsAndConditionComponent } from './terms-and-condition/terms-and-condition.component';
import { PrivacyPolicyComponent } from './privacy-policy/privacy-policy.component';
import { RefundPolicyComponent } from './refund-policy/refund-policy.component';
import { RegistrationformComponent } from './registrationform/registrationform.component';
import { LoginformComponent } from './loginform/loginform.component';
import { AddpartnersComponent } from './addpartners/addpartners.component';
import { AddtaxiComponent } from './addtaxi/addtaxi.component';
import { AdddriverComponent } from './adddriver/adddriver.component';
import { LoginpartnerComponent } from './loginpartner/loginpartner.component'
const routes: Routes = [
  { path: 'home', component: IndexComponent },
  { path: '',   redirectTo: '', pathMatch: 'full', component: IndexComponent }, // redirect to `first-component`
  { path: 'logIn', component: LoginformComponent },
  { path: 'signUp', component: RegistrationformComponent },
  { path: 'addpartners', component: AddpartnersComponent },
  { path: 'loginpartner', component: LoginpartnerComponent },
  { path: 'addtaxi', component: AddtaxiComponent },
  { path: 'adddriver', component: AdddriverComponent },
  { path: 'termsandCondition', component: TermsAndConditionComponent },
  { path: 'privacyPolicy', component:  PrivacyPolicyComponent },
  { path: 'refundPolicy', component: RefundPolicyComponent },
  { path: '**', component: IndexComponent },

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
