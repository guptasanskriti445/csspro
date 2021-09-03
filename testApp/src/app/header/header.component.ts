import { Component, OnInit } from '@angular/core';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import { from } from 'rxjs';
import { ServicesService } from '../services.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

loginForm: FormGroup;
invalidLogin: boolean = false;
message: any;
  constructor(private formBuilder: FormBuilder, private apiservice: ServicesService, private router: Router) { }
  
  ngOnInit(): void {
    this.loginForm=this.formBuilder.group({
      email: ['',Validators.compose([Validators.required])],
      password: ['',Validators.required]
    });
  }
  onSubmit(){
    console.log(this.loginForm.value);
    if(this.loginForm.invalid){
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
        this.router.navigate(['/']);
      }
      else{
        this.invalidLogin = true;
      }
   });
  }

} 
