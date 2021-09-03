import { Component, OnInit } from '@angular/core';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import { ServicesService } from '../services.service';
import { Router } from '@angular/router';
@Component({
  selector: 'app-loginform',
  templateUrl: './loginform.component.html',
  styleUrls: ['./loginform.component.css']
})
export class LoginformComponent implements OnInit {
  loginForm: FormGroup;
  // loading = false;
  submitted = false;
  returnUrl: string;
message: any;
  constructor(private formBuilder: FormBuilder, private apiservice: ServicesService, private router: Router) {
  //   if (this.apiservice.currentUserValue) { 
  //     this.router.navigate(['/']);
  // }
   }

  ngOnInit(): void {
    this.loginForm=this.formBuilder.group({
      email: ['',Validators.compose([Validators.required])],
      password: ['',Validators.required]
    });
  }
  onSubmit(){
    this.submitted = true;
    console.log(this.loginForm.value);
    if (this.loginForm.invalid) {    
      return;
  } 
    const loginData = {
         email: this.loginForm.controls.email.value,
         passowrd: this.loginForm.controls.password.value
    };
   ;
    this.apiservice.login(loginData).subscribe((data: any) =>{
      this.message = data.message;
      if(data.token){
        window.localStorage.setItem('token',data.token);
      }
      this.router.navigate([]);
      
   });
  }

}
