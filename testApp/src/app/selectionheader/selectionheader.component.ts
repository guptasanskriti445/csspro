import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, FormBuilder, Validators, NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { ApiResponse } from '../Model/api-response';
import { ServicesService } from '../services.service';
// import * as data from "./citys.json";
@Component({
  selector: 'app-selectionheader',
  templateUrl: './selectionheader.component.html',
  styleUrls: ['./selectionheader.component.css']
  // providers:['SearchService']
})
export class SelectionheaderComponent implements OnInit {
  // Citys: any = data;
  currentday = new Date().toISOString().split('T')[0];
  options: any;
  
  searchForm: FormGroup;
  constructor(private apiservice:ServicesService,private fb: FormBuilder, private router:Router) { 
    this.searchForm = this.fb.group({
      pickupCity: ['', [Validators.required]],
      destinationCity: ['', Validators.required],
      journeyDate: ['', Validators.required],
      journeytime: ['', Validators.required],
      mobile_no: ['', Validators.required],
      trip_type: ['', Validators.required]
      });
      
  }
  ngOnInit(): void {
     
    this.apiservice.getSearch().subscribe(data => {
      this.options = data;
    });

  }
  onSubmit() {
    console.log(this.searchForm.value);
    console.log(this.searchForm.value.trip_type);
    this.apiservice.searchCab(this.searchForm.value).subscribe(data => {
      this.router.navigate([]);
    });
  }

}
 