import {Injectable} from '@angular/core';
import {ReportComponent} from '../component/report/report.component';

@Injectable({
  providedIn: 'root'
})
export class ReportRepositoryService {

  private _reports: ReportComponent[];

  constructor() {
  }

  get items(): ReportComponent[] {
    return this._reports;
  }

  getReportsForDownload() {
    return this._reports.filter(item => item.download);
  }

  public init(reports: ReportComponent[]) {
    this._reports = reports;
  }
}
