import {Component, OnInit, QueryList, ViewChildren} from '@angular/core';
import {ReportRepositoryService} from '../../service/report-repository.service';
import {environment} from '../../../environments/environment';
import {ReportComponent} from '../report/report.component';

@Component({
  selector: 'report-list',
  templateUrl: './report-list.component.html',
  styleUrls: ['./report-list.component.css'],
})
export class ReportListComponent implements OnInit {

  @ViewChildren(ReportComponent) reports: QueryList<ReportComponent>;

  public baseUrl: string = environment.apiBaseUrl;


  constructor(protected reportRepository: ReportRepositoryService) {
  }

  ngOnInit() {
  }

  ngAfterViewInit() {
    this.reportRepository.init(this.reports.toArray());
  }
}
