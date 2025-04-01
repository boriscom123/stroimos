import {BehaviorSubject, forkJoin, Subscription} from 'rxjs';
import {first, map, skipWhile} from 'rxjs/operators';
import * as Excel from 'exceljs/dist/exceljs.min.js';
import * as FileSaver from 'file-saver';
import {ReportComponent} from '../component/report/report.component';

const EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
const EXCEL_EXTENSION = '.xlsx';

export default class DownloadReportsTask {

  private observableState: BehaviorSubject<{}>;
  private observableStateSubscription: Subscription;
  private workSheets = {};
  private workbook;

  constructor(protected reports) {
    if (!reports.length) {
      throw new Error();
    }
    this.workbook = new Excel.Workbook();
  }

  protected _total: number = 0;

  get total() {
    return this._total;
  }

  protected _current: number = 0;

  get current() {
    return this._current;
  }

  private _isStarted: boolean = false;

  get isStarted() {
    return this._isStarted;
  }

  public addDataToSheet(newSubtaskState) {
    let isFirstPage = newSubtaskState.skip === 0;
    let report = newSubtaskState.report;
    let worksheet = this.workbook.getWorksheet(report.excelExporterOptions.title);

    if (!isFirstPage && !worksheet) {
      throw new Error();
    }

    if (isFirstPage) {
      this._total = this._total + newSubtaskState.total;
      worksheet = this.workbook.addWorksheet(report.excelExporterOptions.title);
      worksheet.columns = report.excelExporterOptions.columns;
    }

    worksheet.addRows(newSubtaskState.data);

    this._current = this._current + newSubtaskState.take;
  }

  public loadAllContent() {
    let subtasks = this.reports.map(report => {
      let observableToLoadData = report.loadAllData(100).pipe(
        map((state: any) => {
          state.report = report;
          return state;
        })
      );
      observableToLoadData.subscribe(this.addDataToSheet.bind(this));
      return observableToLoadData.pipe(
        skipWhile((state: any) => state.skip + state.take < state.total),
        first()
      );
    });

    return forkJoin(subtasks);
  }

  public start() {
    this.observableState = new BehaviorSubject({});
    this.observableStateSubscription = this.loadAllContent().subscribe(this.saveContentToFile.bind(this));
    this._isStarted = true;
    return this.observableState;
  }

  public stop() {
    this._isStarted = false;
    this.observableStateSubscription.unsubscribe();
    this.observableState = null;
  }

  public saveContentToFile(subtasks) {
    this.stop();
    this.workbook.xlsx.writeBuffer().then(buffer => {
      const data: Blob = new Blob([buffer], {
        type: EXCEL_TYPE
      });

      FileSaver.saveAs(data, 'test_export_' + new Date().getTime() + EXCEL_EXTENSION);
    });
  }

  protected createWorkSheet(report: ReportComponent) {
    let excelOptions = report.excelExporterOptions;
    let worksheet = this.workbook.addWorksheet(excelOptions.title);

    worksheet.columns = excelOptions.columns;

    return worksheet;
  }

}
