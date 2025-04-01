import {Injectable} from '@angular/core';
import {PostService} from './post.service';
import {PostEntity} from './post.entity';
import {map} from 'rxjs/operators';
import {debug} from 'util';

@Injectable({
  providedIn: 'root'
})
export class PostRepositoryService {

  private collection = {};

  constructor(private postService: PostService) {
  }

  add(entity: PostEntity) {
    this.collection[entity.id] = entity;
  }

  pullAll(postService: PostService, excludeItems:Array<PostEntity> = null) {
    let ids = [];
    let excludeIds = {};
    excludeItems.forEach((item:PostEntity) => excludeIds[item.id] = true);
    for(let id in this.collection) {
      if (excludeIds[id]) {
        continue;
      }
      ids.push(id);
      this.collection[id].lock();
    }

    return postService
      .findBy({filter: {field:'id', operator: 'in', value:ids}})
      .pipe(
        map((data) => {
          this.updateAndUnlockItems(data);
          return data;
        })
      );
  }

  private updateAndUnlockItems(newItems: Array<PostEntity>) {
    newItems.forEach((item) => {
      this.collection[item.id].mergeWith(item).unlock();
    });
  }
}
