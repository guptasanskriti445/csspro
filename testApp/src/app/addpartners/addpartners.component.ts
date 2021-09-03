import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators} from '@angular/forms';
import { Title, Meta } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { ServicesService } from '../services.service';

@Component({
  selector: 'app-addpartners',
  templateUrl: './addpartners.component.html',
  styleUrls: ['./addpartners.component.css']
})
export class AddpartnersComponent implements OnInit {
  title = 'Add Partner';
  addpartnersForm: FormGroup;
  invalidlogin: boolean = false;
  submitted = false;
  loading = false;
  constructor(private apiservice:ServicesService,private fb: FormBuilder, private router: Router, private titleService:Title, private metaTagService: Meta) { 
    this.addpartnersForm = this.fb.group({
      id: [],
      name: ['', Validators.required],
      phoneNo: ['',[Validators.required, Validators.pattern("^[0-9]*$"), Validators.maxLength(10)]],
      email: ['',  [Validators.required, Validators.email]],
      city: ['', [Validators.required]],
      password: ['', [Validators.required]]
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
        if (this.addpartnersForm.valid) {
         
          // return console.log('Account created successfully');
          console.log(this.addpartnersForm.value);
        this.apiservice.addpartners(this.addpartnersForm.value).subscribe(data => {
          this.router.navigate([]);
        });
        }
        
        this.loading = true;

      }

}
