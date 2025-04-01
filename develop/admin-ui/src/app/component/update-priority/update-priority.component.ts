import {ChangeDetectorRef, Component, ElementRef, Input, OnDestroy, OnInit, Renderer2, ViewChild, ViewEncapsulation} from '@angular/core';
import {PostRepositoryService} from './post-repository.service';
import {FormBuilder} from '@angular/forms';
import {PostService} from './post.service';
import {PostEntity, State} from './post.entity';
import {faPen} from '@fortawesome/free-solid-svg-icons/faPen';
import {faExclamationTriangle, faTimes} from '@fortawesome/free-solid-svg-icons';
import {NgSelectComponent} from '@ng-select/ng-select';
import {ComponentRepositoryService} from './component-repository.service';
import {BehaviorSubject} from 'rxjs';
import {faSpinner} from '@fortawesome/free-solid-svg-icons/faSpinner';
import {HttpClient} from '@angular/common/http';
import {concatMap} from 'rxjs/operators';

const priorityOptions = [];

for(let i=0; i<=PostEntity.MAX_PRIORITY_VALUE; i++) {
  priorityOptions.push({
    value: i,
    label: (i=== PostEntity.UNDEFINED_PRIORITY_VALUE) ? 'Без приоритета' : i
  })
}

@Component({
  selector: 'update-priority',
  templateUrl: './update-priority.component.html',
  styleUrls: ['./update-priority.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class UpdatePriorityComponent implements OnDestroy, OnInit {
  public faPen = faPen;
  public faTimes = faTimes;
  public faSpinner = faSpinner;
  public faExclamationTriangle = faExclamationTriangle;
  public isEditMode = new BehaviorSubject(false);
  public isError: boolean = false;
  @Input() entityId: string;
  @Input() priority: number = 0;
  public post: PostEntity;

  @ViewChild('selectPriority', {static: false}) select: NgSelectComponent;
  private selectedPriority: number;
  private selectPriority: ElementRef;

  constructor(
    private renderer: Renderer2,
    private componentRepository: ComponentRepositoryService,
    private detector: ChangeDetectorRef,
    private formBuilder: FormBuilder,
    private repository: PostRepositoryService,
    private postService: PostService,
    public http: HttpClient
  ) {
    this.renderer.listen('window', 'click', (e: Event) => {
      if (this.isEditMode.value) {
        this.disable();
      }
    });
  }

  get stateEnum() {
    return State;
  }

  get priorityOptions() {
    return priorityOptions;
  }

  ngOnDestroy(): void {
    this.post = null;
  }

  ngOnInit(): void {
    this.post = new PostEntity(this.entityId, this.priority);
    this.selectedPriority = this.post.priority;

    this.repository.add(this.post);
    this.componentRepository.add(this);
  }

  enable() {
    this.isEditMode.next(true);
  }

  disable() {
    if (this.isPriorityChanged() && !this.post.is(State.pushingChanges)) {
      this.isEditMode.next(false);

      let prioritySubject = this.selectedPriority == 0
        ? this.post.deletePriority(this.postService)
        : this.post.changePriority(this.postService, this.selectedPriority);

      prioritySubject
        .pipe(
          concatMap(result => {
            this.selectedPriority = this.post.priority;
            return this.repository.pullAll(this.postService, [this.post]);
          })
        )
        .subscribe({
          error: (error) => {
            this.isError = true;
          }
        });
    }
  }

  toggle() {
    this.isEditMode.next(!this.isEditMode.value);
  }

  clickButton() {
    if (this.post.is(State.locked)) {
      return;
    }
    this.toggle();
    this.detector.detectChanges();
    if (this.isEditMode.value) {
      this.select.open();
    }
  }

  protected isPriorityChanged() {
    return this.post.priority !== this.selectedPriority;
  }
}
