import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../../environments/environment';
import {map} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class PostService {

  private apiBaseUrl = environment.apiBaseUrl;

  constructor(public http: HttpClient) {
  }

  public findBy(criteria: object) {
    return this.http
      .get<any>(
        `${this.apiBaseUrl}/admin/api/posts`,
        {params: {criteria: JSON.stringify(criteria)}}
      ).pipe(
        map((data) => data['data'])
      );
  }

  public putProperty(id: string, propertyName: string, value: any) {

    return this.http.put<any>(
      `${this.apiBaseUrl}/admin/api/posts/${id}/${propertyName}`,
      JSON.stringify(value)
    );
  }

  public deletePropertyValue(id: string, propertyName: string) {
    return this.putProperty(id, propertyName, null);
  }


}
