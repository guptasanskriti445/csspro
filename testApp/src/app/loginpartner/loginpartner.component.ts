import { Component, OnInit } from '@angular/core';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import { Title, Meta } from '@angular/platform-browser';
import { ServicesService } from '../services.service';

@Component({
  selector: 'app-loginpartner',
  templateUrl: './loginpartner.component.html',
  styleUrls: ['./loginpartner.component.css']
})
export class LoginpartnerComponent implements OnInit {
  title = 'LogIn Partner';
  loginpartner: FormGroup;
  // loading = false;
  submitted = false;
  returnUrl: string;
message: any;
  constructor(private formBuilder: FormBuilder, private apiservice: ServicesService,private titleService:Title, private metaTagService: Meta) { }

  ngOnInit(): void {
    this.titleService.setTitle(this.title);
    this.metaTagService.updateTag(
      { name: 'description', content: 'Ococbas' }
    );
    this.loginpartner=this.formBuilder.group({
      email: ['',Validators.compose([Validators.required])],
      password: ['',Validators.required]
    });
  }
  onSubmit(){
    this.submitted = true;
    console.log(this.loginpartner.value);
    if (this.loginpartner.invalid) {    
      return;
  } 
    const loginpartnerData = {
         email: this.loginpartner.controls.email.value,
         passowrd: this.loginpartner.controls.password.value
    };
   ;
    this.apiservice.loginpartner(loginpartnerData).subscribe((data: any) =>{
      this.message = data.message;
      if(data.token){
        window.localStorage.setItem('token',data.token);
      }
      
   });
  }

}
