import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Media} from '../model/Media';
import {map} from 'rxjs/operators';
import {environment} from '../../environments/environment';

@Injectable({
    providedIn: 'root'
})
export class AdminHttpClientService {

    private apiBaseUrl = environment.apiBaseUrl;

    constructor(protected httpClient: HttpClient) {
    }

    public createGifFromMedias(mediaIds: Array<string>): Observable<Media> {
        return this.httpClient.post<Media>(
            `${this.apiBaseUrl}/admin/api/medias/animated-gif`,
            JSON.stringify(mediaIds)
        ).pipe(
            map((data: Object): Media => {
                return data as Media;
            })
        );
    }

    // public delete(): Observable<string> {
    //   return this.httpClient.delete(
    //       'admin/gallery/wallpaper/create',
    //       null
    //   );
    // }
}
