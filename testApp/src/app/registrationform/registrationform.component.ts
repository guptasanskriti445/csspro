import { Route } from '@angular/compiler/src/core';
import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators} from '@angular/forms';
import { Title, Meta } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { ServicesService } from '../services.service';

@Component({
  selector: 'app-registrationform',
  templateUrl: './registrationform.component.html',
  styleUrls: ['./registrationform.component.css']
})
export class RegistrationformComponent implements OnInit {
  title = 'Sign Up ';
  registerForm: FormGroup;
  invalidlogin: boolean = false;
  submitted = false;
  loading = false;
  constructor(private apiservice:ServicesService,private fb: FormBuilder, private router: Router, private titleService:Title, private metaTagService: Meta) { 
    this.registerForm = this.fb.group({
      id: [],
      name: ['', Validators.required],
      email: ['',  [Validators.required, Validators.email]],
      mobileNo: ['',[Validators.required, Validators.pattern("^[0-9]*$"), Validators.maxLength(10)]],
      password: ['', [Validators.required]]
      });
      // , Validators.pattern(/\-?\d*\.?\d{1,2}/)
  }
  ngOnInit(): void {
    this.titleService.setTitle(this.title);
    this.metaTagService.updateTag(
      { name: 'description', content: 'Ococbas' }
    );
  }
  onSubmit() { 
   
    this.submitted = true;
        this.loading = false;
        if (this.registerForm.valid) {
         
          // return console.log('Account created successfully');
          console.log(this.registerForm.value);
        this.apiservice.createUser(this.registerForm.value).subscribe(data => {
          this.router.navigate(['/']);
        });
        }
        
        this.loading = true;

      }
  
   
  

}
