import {PostService} from './post.service';
import {catchError, finalize} from 'rxjs/operators';
import {throwError} from 'rxjs';

export enum State {
  locked = 'locked',
  pushingChanges ='pushingChanges'
}


export class PostEntity implements EntityWithPriorityInterface {

  static readonly MAX_PRIORITY_VALUE = 8;
  static readonly UNDEFINED_PRIORITY_VALUE = 0;

  private _state: State = null;

  constructor(private _id: string, private _priority: number = 0) {

  }

  is(state: State) {
    return this._state as State === state as State;
  }

  get id(): string {
    return this._id;
  }

  get priority(): number {
    return (this._priority > PostEntity.MAX_PRIORITY_VALUE)
      ? 0
      : this._priority;
  }

  public changePriority(postService: PostService, newPriority: number) {
    let oldPriority = this._priority;
    this._priority = newPriority;
    this._state = State.pushingChanges;
    return postService
      .putProperty(this.id, 'priority', this.priority)
      .pipe(
        finalize(() => this._state = null),
        catchError(error => {
          this._priority = oldPriority;
          return throwError(error);
        }),
      );
  }

  public deletePriority(postService: PostService) {
    let oldPriority = this._priority;
    this._priority = PostEntity.UNDEFINED_PRIORITY_VALUE;
    this._state = State.pushingChanges;
    return postService
      .deletePropertyValue(this.id, 'priority')
      .pipe(
        finalize(() => this._state = null),
        catchError(error => {
          this._priority = oldPriority;
          return throwError(error);
        }),
      );
  }

  public mergeWith(data:any): PostEntity {
    if (data.priority) {
      this._priority = data.priority;
    }

    return this;
  }

  public lock() {
    return this._state = State.locked;
  }

  public unlock() {
    return this._state = null;
  }
}
