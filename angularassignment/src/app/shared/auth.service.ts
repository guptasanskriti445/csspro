import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor() { }
  check(email: string, password: string ){
    if(email =='user@gmail.com' && password =='user@123') {
    localStorage.setItem('email',"user@gmail.com");
    return true;
    }
    else{
      localStorage.clear();
      return false;
    }
  }
}
