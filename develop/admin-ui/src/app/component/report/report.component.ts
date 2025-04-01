import {Component, Input, OnInit, TemplateRef} from '@angular/core';
import {ExcelExporterOptionsInterface} from './excel-exporter-options.interface';
import {Observable, Subject, Subscription} from 'rxjs';
import {ReportDataLoaderService} from '../../service/report-data-loader.service';
import {FilterStorageService} from '../../service/filter-storage.service';
import {map} from 'rxjs/operators';
import {CompositeFilterDescriptor, FilterDescriptor, State} from '@progress/kendo-data-query';

@Component({
  selector: 'report',
  templateUrl: './report.component.html'
})
export class ReportComponent implements OnInit{

  @Input() title: string;
  @Input() url: string;
  @Input() excelExporterOptions: ExcelExporterOptionsInterface;
  @Input() detailsBody: TemplateRef<any>;
  @Input() fieldNameWithCreationDatetime: string = 'createdAt';

  public ctx = {url: '', fieldNameWithCreationDatetime: ''};
  public showDetails: boolean = false;
  public download: boolean = false;

  private filterSubscription: Subscription;
  private subscriberOnDataLoading: any;
  private observableFilterState: Observable<any>;
  private observalbleStateOfLoadingAllData: Subject<any>;
  private state: State = {};

  constructor(
    private dataLoaderService: ReportDataLoaderService,
    private filterStorage: FilterStorageService
  ) {
    this.observableFilterState = this.filterStorage.getFilterWatcher();
  }

  public ngOnInit(): void {
    this.ctx.url = this.url;
    this.ctx.fieldNameWithCreationDatetime = this.fieldNameWithCreationDatetime;
    this.filterSubscription = this.observableFilterState
        .pipe(map(item => item))
        .subscribe(this.applyFilters.bind(this));
  }

  public ngOnDestroy() {
    this.filterSubscription.unsubscribe();
  }

  protected loadDataChunk(url: string, filters: object, skip: number, take: number) {
    filters['skip'] = skip;
    filters['take'] = take;

    return this.dataLoaderService
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
      .loadDataChunk(this.url, this.state, 0, chunkSize)
      .subscribe(this.emitDataAndLoadNextChunk.bind(this));
    return this.observalbleStateOfLoadingAllData;

  }

  protected emitDataAndLoadNextChunk(state) {
    this.observalbleStateOfLoadingAllData.next(state);

    if (state.skip + state.take >= state.total) {
      return;
    }

    this.subscriberOnDataLoading = this
      .loadDataChunk(this.url, this.state, state.skip + state.take, state.take)
      .subscribe(this.emitDataAndLoadNextChunk.bind(this));
  }


  protected applyFilters(filters: any = null) {
    if (!filters.created || (!filters.created.start && !filters.created.start)) {
      this.state = {};
      return;
    }
    let stateFilters = [];

    if (filters.created.start) {
      stateFilters.push({
        field: this.fieldNameWithCreationDatetime,
        operator: 'gte',
        value: filters.created.start
      } as FilterDescriptor);
    }

    if (filters.created.end) {
      stateFilters.push({
        field: this.fieldNameWithCreationDatetime,
        operator: 'lte',
        value: filters.created.end
      } as FilterDescriptor);
    }

    this.state.filter = {
      logic: 'and',
      filters: stateFilters
    } as CompositeFilterDescriptor;
  }
}
