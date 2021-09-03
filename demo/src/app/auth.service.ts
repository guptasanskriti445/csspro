import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor() { }
  check(email: string, password: string ){
    if(email =='admin@gmail.com' && password =='admin') {
    localStorage.setItem('email',"admin@gmail.com");
    return true;
    }
    else{
      localStorage.clear();
      return false;
    }
  }
  
}
