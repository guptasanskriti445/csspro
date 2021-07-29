import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators, EmailValidator} from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../shared/auth.service';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  login: FormGroup;
  invalidlogin= false;
  submitted = false;
  loading = false;
  constructor(private fb: FormBuilder, private router: Router, private service: AuthService) {
    this.login = this.fb.group({
      id: [],
      email: ['', Validators.required],
      password: ['', Validators.required]
      });
   }
 msg;
  ngOnInit(): void {
    localStorage.clear();

  }
  

    check(email:string, p:string){
      var output= this.service.check(email, p);
      if(output == true){
        this.router.navigate(['/dashboard']);
      }
      else{
        this.msg="Invaild email and password";
      }
    }
}
