import {BrowserModule} from '@angular/platform-browser';
import {ElementRef, Injector, NgModule} from '@angular/core';
import {createCustomElement} from '@angular/elements';


import {GridModule} from '@progress/kendo-angular-grid';
import { SortableModule } from '@progress/kendo-angular-sortable';
import {DateInputsModule} from '@progress/kendo-angular-dateinputs';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {IntlModule} from '@progress/kendo-angular-intl';
import {POPUP_CONTAINER} from '@progress/kendo-angular-popup';
import {ComboBoxModule} from '@progress/kendo-angular-dropdowns';
import {ReportListComponent} from './component/report-list/report-list.component';
import {ReportFilterFormComponent} from './component/report-filter-form/report-filter-form.component';
import {HttpClientJsonpModule, HttpClientModule} from '@angular/common/http';
import {ReportDataProviderDirective} from './directive/report-data-provider.directive';
import {ReportComponent} from './component/report/report.component';
import {NewsGridComponent} from './component/news-grid/news-grid.component';
import { DropDownListModule } from '@progress/kendo-angular-dropdowns';
import { EditService } from './component/news-grid/edit.service';
import {UpdatePriorityComponent} from './component/update-priority/update-priority.component';
import {FontAwesomeModule} from '@fortawesome/angular-fontawesome';
import { NgSelectModule } from '@ng-select/ng-select';
import {ClickOutsideModule} from 'ng-click-outside';
import { GifGeneratorComponent } from './component/gif-generator/gif-generator.component';

@NgModule({
  declarations: [
    ReportListComponent,
    ReportFilterFormComponent,
    ReportComponent,
    ReportDataProviderDirective,
    NewsGridComponent,
    UpdatePriorityComponent,
    GifGeneratorComponent,
  ],
  imports: [
    ComboBoxModule,
    BrowserModule,
    GridModule,
    BrowserAnimationsModule,
    ReactiveFormsModule,
    IntlModule,
    DateInputsModule,
    FormsModule,
    HttpClientModule,
    DropDownListModule,
    HttpClientJsonpModule,
    FontAwesomeModule,
    NgSelectModule,
    ClickOutsideModule,
    SortableModule
  ],
  entryComponents: [
    ReportListComponent,
    ReportComponent,
    ReportFilterFormComponent,
    NewsGridComponent,
    GifGeneratorComponent,
    UpdatePriorityComponent
  ],
  providers: [
    {
      provide: POPUP_CONTAINER,
      useFactory: () => {
        return ({nativeElement: document.body} as ElementRef);
      }
    },
    EditService
  ]
})
export class AppModule {
  constructor(private injector: Injector) {
    customElements.define(
      'report-filter-form',
      createCustomElement(ReportFilterFormComponent, {injector})
    );

    customElements.define(
        'gif-generator',
        createCustomElement(GifGeneratorComponent, {injector})
    );

    customElements.define(
      'report-list',
      createCustomElement(ReportListComponent, {injector})
    );

    customElements.define(
      'update-priority',
      createCustomElement(UpdatePriorityComponent,{injector})
    );
  }

  ngDoBootstrap() {
  }
}
