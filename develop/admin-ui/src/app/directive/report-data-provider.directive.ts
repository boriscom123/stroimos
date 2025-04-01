import {ApplicationRef, Directive, Input, OnDestroy, OnInit} from '@angular/core';
import {DataBindingDirective, GridComponent, GridDataResult} from '@progress/kendo-angular-grid';
import {ReportDataLoaderService} from '../service/report-data-loader.service';
import {FilterStorageService} from '../service/filter-storage.service';
import {Observable, Subject, Subscription} from 'rxjs';
import {CompositeFilterDescriptor} from '@progress/kendo-data-query/dist/npm/filtering/filter-descriptor.interface';
import {map} from 'rxjs/operators';
import {FilterDescriptor} from '@progress/kendo-data-query';

@Directive({
  selector: '[appReportDataProvider]'
})
export class ReportDataProviderDirective extends DataBindingDirective implements OnInit, OnDestroy {

  @Input() url: string;
  @Input() fieldNameWithCreationDatetime: string = 'createdAt';

  protected filterSubscription: Subscription;
  private subscriberOnDataLoading: any;
  private observableFilterState: Observable<any>;
  private observalbleStateOfLoadingAllData: Subject<any>;
  private _filters: object[];

  constructor(
    public grid: GridComponent,
    private ref: ApplicationRef,
    private reportDataProvider: ReportDataLoaderService,
    private filterStorage: FilterStorageService
  ) {
    super(grid);
    this.observableFilterState = this.filterStorage.getFilterWatcher();
  }

  public ngOnInit(): void {
    super.ngOnInit();
    this.filterSubscription = this.observableFilterState.subscribe(this.applyFilters.bind(this));
  }

  public ngOnDestroy() {
    this.filterSubscription.unsubscribe();
  }

  public rebind() {
    this.grid.loading = true;

    if (this._filters) {
      this.state.filter = {
        logic: 'and',
        filters: this._filters
      } as CompositeFilterDescriptor;
    }

    this
      .loadData(this.url, this.state, this.state.skip, this.state.take)
      .subscribe((data) => {

        this.grid.data = (<GridDataResult>{
          data: data['data'],
          total: parseInt(data['total'], 10)
        });
        this.notifyDataChange();
        this.grid.loading = false;
      });
  }

  loadData(url: string, filters: object, skip: number, take: number) {
    filters['skip'] = skip;
    filters['take'] = take;

    return this.reportDataProvider
      .loadData(this.url, filters)
      .pipe(
        map((requestResult: any) => {
          return {
            skip: skip,
            take: take,
            data: requestResult.data,
            total: requestResult.total,
          };
        })
      );
  }

  loadAllData(chunkSize: number = 100) {
    this.observalbleStateOfLoadingAllData = new Subject();
    this.subscriberOnDataLoading = this
      .loadData(this.url, this.state, 0, chunkSize)
      .subscribe(this.exportDataAndLoadNextChunk.bind(this));
    return this.observalbleStateOfLoadingAllData;

  }

  exportDataAndLoadNextChunk(state) {
    this.observalbleStateOfLoadingAllData.next(state);

    if (state.skip + state.take >= state.total) {
      return;
    }

    this.subscriberOnDataLoading = this
      .loadData(this.url, this.state, state.skip + state.take, state.take)
      .subscribe(this.exportDataAndLoadNextChunk.bind(this));
  }

  public getData() {
    return this.grid.data;
  }

  protected applyFilters(filters: any = null) {
    this._filters = [];

    if (filters.created && filters.created.start) {
      this._filters.push({
        field: this.fieldNameWithCreationDatetime,
        operator: 'gte',
        value: filters.created.start

      } as FilterDescriptor);
    }

    if (filters.created && filters.created.end) {
      this._filters.push({
        field: this.fieldNameWithCreationDatetime,
        operator: 'lte',
        value: filters.created.end
      } as FilterDescriptor);
    }

    this.rebind();
  }

}
