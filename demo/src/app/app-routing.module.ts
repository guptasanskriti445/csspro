import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { AdminGuard } from './admin/admin.guard';

const routes: Routes = [
  { path: 'home', component: LoginComponent },
  { path: '',   redirectTo: '', pathMatch: 'full', component: LoginComponent }, // redirect to `first-component`
  { path: 'login', component: LoginComponent },
  { path: 'dashboard', canActivate : [AdminGuard], component: DashboardComponent },
  { path: '**', component: LoginComponent },
];

@NgModule({ 
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
