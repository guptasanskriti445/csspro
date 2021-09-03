import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators} from '@angular/forms';
import { Title, Meta } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { ServicesService } from '../services.service';
@Component({
  selector: 'app-addtaxi',
  templateUrl: './addtaxi.component.html',
  styleUrls: ['./addtaxi.component.css']
})
export class AddtaxiComponent implements OnInit {
  title = 'Add Taxi';
  addtaxiForm: FormGroup;
  invalidlogin: boolean = false;
  submitted = false;
  loading = false;
  constructor(private apiservice:ServicesService,private fb: FormBuilder, private router: Router, private titleService:Title, private metaTagService: Meta) {
    this.addtaxiForm = this.fb.group({
      id: [],
      cartype: ['', Validators.required],
      registrationCertificate: ['', Validators.required],
      fueltype: ['', Validators.required],
      passangercapacity: ['', [Validators.required, Validators.pattern("^[0-9]*$")]],
      insurance: ['', Validators.required],
      fitness: ['', Validators.required],
      permit: ['', Validators.required],
      puc: ['', Validators.required],
      carfrontimage: ['', Validators.required],
      carbackimage: ['', Validators.required],
      
      });
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
        if (this.addtaxiForm.valid) {
         
          // return console.log('Account created successfully');
          console.log(this.addtaxiForm.value);
        this.apiservice.addtaxi(this.addtaxiForm.value).subscribe(data => {
          this.router.navigate([]);
        });
        }
        
        this.loading = true;

      }

}
