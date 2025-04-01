import {Component, ViewEncapsulation} from '@angular/core';
import {FormBuilder} from '@angular/forms';
import {FilterStorageService} from '../../service/filter-storage.service';
import {ReportRepositoryService} from '../../service/report-repository.service';
import DownloadReportsTask from '../../model/DownloadReportsTask';
import {BehaviorSubject} from 'rxjs';
import {ReportComponent} from '../report/report.component';
import moment from 'moment';

@Component({
    selector: 'report-filter-form',
    templateUrl: './report-filter-form.component.html',
    styleUrls: ['./report-filter-form.component.scss'],
})
export class ReportFilterFormComponent {

    private observableDownloadTaskState: BehaviorSubject<{}>;
    public downloadTask: DownloadReportsTask;
    public created = {start: null, end: null};

    constructor(
        private formBuilder: FormBuilder,
        private filterStorage: FilterStorageService,
        public reportRepository: ReportRepositoryService
    ) {
    }


    public toggleDownload(event, reportcomponent: ReportComponent) {
        reportcomponent.download = !reportcomponent.download;
    }

    public toggleShowDetails(event, reportcomponent: ReportComponent) {
        reportcomponent.showDetails = !reportcomponent.showDetails;
    }

    public onCreatedPeriodChange(value) {

        if (!value.start || !value.end) {
            return;
        }

        const currentFilters = this.filterStorage.filters;

        const newStart = moment(value.start).format();
        const newEnd = moment(value.end).add(1, 'days').format();

        if (currentFilters['created'] && newStart === currentFilters['created']['start'] && newEnd === currentFilters['created']['end']) {
            return;
        }
        currentFilters['created'] = {
            start: newStart,
            end: newEnd
        };
        this.filterStorage.filters = currentFilters;
    }

    public startDownload() {
        let reports = this.reportRepository.getReportsForDownload();
        if (!reports.length) {
            alert('Выбирите отчеты для выгрузки');
            return;
        }

        this.downloadTask = new DownloadReportsTask(reports);
        this.observableDownloadTaskState = this.downloadTask.start();
    }

    public cancelDownload() {
        this.downloadTask.stop();
        this.downloadTask = null;
    }
}
