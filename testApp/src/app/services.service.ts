import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import {User} from './Model/user';
import { ApiResponse } from './Model/api-response';

@Injectable({
  providedIn: 'root'
})
export class ServicesService {

  constructor(private http:HttpClient) { }
baseUrl='https://www.ococabs.com';

login(loginData): Observable<ApiResponse>{
return this.http.post<ApiResponse>(this.baseUrl + '/login.php', loginData);
}

createUser(user:User): Observable<ApiResponse>{
return this.http.post<ApiResponse>(this.baseUrl + '/register.php', user);
}

searchCab(search:User): Observable<ApiResponse>{
return this.http.post<ApiResponse>(this.baseUrl + '/searchapi.php', search);
}
 
getSearch(): Observable<ApiResponse>{
  return this.http.get<ApiResponse>(this.baseUrl + '/searchcity.php');
  }

  addtaxi(addtaxi:User): Observable<ApiResponse>{
    return this.http.post<ApiResponse>(this.baseUrl + '/addtaxi.php', addtaxi);
    }
    adddriver(adddriver:User): Observable<ApiResponse>{
      return this.http.post<ApiResponse>(this.baseUrl + '/addtaxi.php', adddriver);
      }

    addpartners(addpartners:User): Observable<ApiResponse>{
      return this.http.post<ApiResponse>(this.baseUrl + '/addpartner.php', addpartners);
      }  

      loginpartner(loginpartnerData): Observable<ApiResponse>{
        return this.http.post<ApiResponse>(this.baseUrl + '/loginpartner.php', loginpartnerData);
        }

}
