import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators} from '@angular/forms';
import { Title, Meta } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { ServicesService } from '../services.service';
@Component({
  selector: 'app-adddriver',
  templateUrl: './adddriver.component.html',
  styleUrls: ['./adddriver.component.css']
})
export class AdddriverComponent implements OnInit {
  title = 'Add Driver';
  adddriverForm: FormGroup;
  invalidlogin: boolean = false;
  submitted = false;
  loading = false;
  constructor(private apiservice:ServicesService,private fb: FormBuilder, private router: Router, private titleService:Title, private metaTagService: Meta) { 
    this.adddriverForm = this.fb.group({
      id: [],
      dname: ['', Validators.required],
      phoneNo: ['', Validators.required],
      drivinglincence: ['', Validators.required],
      driverselfi: ['', Validators.required],
      aadhar: ['', Validators.required],
      pancard: ['', Validators.required],
      policeveri: ['', Validators.required],
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
        if (this.adddriverForm.valid) {
         
          // return console.log('Account created successfully');
          console.log(this.adddriverForm.value);
        this.apiservice.adddriver(this.adddriverForm.value).subscribe(data => {
          this.router.navigate([]);
        });
        }
        
        this.loading = true;

      }

}
