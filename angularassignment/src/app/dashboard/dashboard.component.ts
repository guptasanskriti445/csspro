import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { ApiService } from '../shared/api.service';
import { EmployeeModule } from './dashboard.module';
import { Router } from '@angular/router';
@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
  formValue !: FormGroup;
  employeeModelObj : EmployeeModule  = new EmployeeModule();
  employeeData !: any;
  showAdd !: boolean;
  showUpdate !: boolean;
  submitted = false;
   
  constructor(private formBuilder: FormBuilder,private api : ApiService,private router: Router) { } 

  ngOnInit(): void {
    this.formValue = this.formBuilder.group({
      firstname : ['', Validators.required],
      lastname : ['', Validators.required],
      address : ['', Validators.required], 
      dob : ['',[Validators.required]],
      mobile : ['',[Validators.required, Validators.minLength(10), Validators.maxLength(10),Validators.pattern("^((\\+91-?)|0)?[0-9]{10}$")]],
      city : ['', Validators.required],
    })
    this.getAllEmployee();
  }
  get f() { return this.formValue.controls;}

  clickAddEmployee(){ 
    this.formValue.reset();
    this.showAdd = true;
    this.showUpdate = false;
  }
  postEmployeeDetails(){
      this.submitted = true;

      // stop here if form is invalid
      if (this.formValue.invalid) {
          return;
      }

      this.employeeModelObj.firstname = this.formValue.value.firstname;
      this.employeeModelObj.lastname = this.formValue.value.lastname;
      this.employeeModelObj.address = this.formValue.value.address;
      this.employeeModelObj.dob = this.formValue.value.dob;
      this.employeeModelObj.mobile = this.formValue.value.mobile;
      this.employeeModelObj.city = this.formValue.value.city;

      this.api.postEmployee(this.employeeModelObj)
      .subscribe(res=>{
        console.log(res);
        alert("Employee Add Successfully")
        let ref = document.getElementById('cancel')
        ref?.click();
        this.formValue.reset();
        this.getAllEmployee();
      },
      err=>{
        alert("Something went wrong")
      })
  }
  getAllEmployee(){
    this.api.getEmployee()
    .subscribe(res=>{
      this.employeeData = res;
    })
  }
  deleteEmployee(row : any){
    this.api.deleteEmployee(row.id)
    .subscribe(res=>{
      alert("Employee Delete");
      this.getAllEmployee(); 
    })
  }
  onEdit(row : any){
    this.formValue.reset();
    this.showAdd = false;
    this.showUpdate = true;
    this.employeeModelObj.id = row.id;
    this.formValue.controls['firstname'].setValue(row.firstname);
    this.formValue.controls['lastname'].setValue(row.lastname);
    this.formValue.controls['address'].setValue(row.address);
    this.formValue.controls['dob'].setValue(row.dob);
    this.formValue.controls['mobile'].setValue(row.mobile);
    this.formValue.controls['city'].setValue(row.city);
  }
  updateEmployeeDetails(){
    this.submitted = true;

    // stop here if form is invalid
    if (this.formValue.invalid) {
        return;
    }
    this.employeeModelObj.firstname = this.formValue.value.firstname;
    this.employeeModelObj.lastname = this.formValue.value.lastname;
    this.employeeModelObj.address = this.formValue.value.address;
    this.employeeModelObj.dob = this.formValue.value.dob;
    this.employeeModelObj.mobile = this.formValue.value.mobile;
    this.employeeModelObj.city = this.formValue.value.city;

    this.api.updateEmployee(this.employeeModelObj,this.employeeModelObj.id)
    .subscribe(res=>{
      alert("Update Successfully")
      let ref = document.getElementById('cancel')
      ref?.click();
      this.formValue.reset();
      this.getAllEmployee();
    })
  }
  logout(){
    localStorage.clear();
    this.router.navigate(['/login']);
  }

}
