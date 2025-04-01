import {Injectable} from '@angular/core';
import {UpdatePriorityComponent} from './update-priority.component';

@Injectable({
  providedIn: 'root'
})
export class ComponentRepositoryService {

  private current: UpdatePriorityComponent = null;

  private components: Array<UpdatePriorityComponent> = [];
  constructor() {
  }

  add(component: UpdatePriorityComponent) {
    this.components.push(component);

    component.isEditMode.subscribe((isActive) => {
      if (!isActive) {
        this.current = null;
        return;
      }

      if (this.current) {
        this.current.disable();
        this.current = null;
      }
      this.current = component;
    });
  }
}
