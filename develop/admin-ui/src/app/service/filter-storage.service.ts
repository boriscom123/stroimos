import {Injectable} from '@angular/core';
import {BehaviorSubject, Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class FilterStorageService {

  private readonly _filters = new BehaviorSubject<object[]>([]);

  readonly filters$ = this._filters.asObservable();

  constructor() {
  }

  get filters(): object[] {
    return this._filters.getValue();
  }

  set filters(newFilters: object[]) {
    this._filters.next(newFilters);
  }

  public getFilterWatcher(): Observable<object[]> {
    return this.filters$;
  }

}
