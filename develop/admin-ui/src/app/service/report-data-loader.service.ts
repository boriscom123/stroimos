import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ReportDataLoaderService {

  constructor(private http: HttpClient) {

  }

  loadData<T>(url: string, criteria: object) {
    const headers = new HttpHeaders().set('Authorization', "Basic " + btoa("manager:vsen0rm"));

    return this.http.get(url, {
      // headers,
      params: {criteria: JSON.stringify(criteria)}
    });
  }
}
