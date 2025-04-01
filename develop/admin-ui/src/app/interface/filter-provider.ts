import {Observable} from 'rxjs';

export interface FilterProvider {
  getFilterAsObservable<T>(): Observable<T>
}
