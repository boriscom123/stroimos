import {Component, Input, OnInit, ViewEncapsulation} from '@angular/core';
import {AdminHttpClientService} from '../../service/admin-http-client.service';
import {Media} from '../../model/Media';
import {NotificationService} from '../../service/notification.service';
import {faSpinner} from '@fortawesome/free-solid-svg-icons/faSpinner';

@Component({
    selector: 'gif-generator',
    templateUrl: './gif-generator.component.html',
    styleUrls: ['./gif-generator.component.scss'],
    encapsulation: ViewEncapsulation.None,
})
export class GifGeneratorComponent implements OnInit {

    public gifMedia: Media = null;
    public faSpinner = faSpinner;
    public pending: boolean = false;
    public images: [] = [];
    public isImagesPanelVisible: boolean = false;
    @Input() name: string;
    @Input() originalValue: string;
    @Input() imagesSelector: string;
    @Input() mediaIdsSelector: string;
    @Input() width: string;
    @Input() height: string;

    constructor(
        private notifier: NotificationService,
        private adminHttpClient: AdminHttpClientService
    ) {
    }

    get mediaId() {
        return this.gifMedia !== null ? this.gifMedia.id : '';
    }

    ngOnInit() {
        if (this.originalValue) {
            this.gifMedia = JSON.parse(this.originalValue) as Media;
        }
    }

    public toggleImagesPanel() {
        this.isImagesPanelVisible = !this.isImagesPanelVisible;
    }

    public openImagesPanel() {
        const imgElements = document.querySelectorAll(this.imagesSelector);
        const inputElements = document.querySelectorAll(this.mediaIdsSelector);
        this.images = Array.prototype.map.call(imgElements, item => item);
        if (!this.images || this.images.length <= 1) {
            this.notifier.alert('Загрузите несколько картинок для создания анимации');
            return false;
        }

        const mediaIds = Array.prototype.map.call(inputElements, item => item.value);
        if (mediaIds && mediaIds.length != this.images.length) {
            throw new Error('The number of media ids does not equal the number of  images')
        }

        this.images.forEach((img: Element, index) => {
            img.setAttribute('mediaId', mediaIds[index]);
        });

        this.isImagesPanelVisible = true;
    }

    public closeImagesPanel() {
        this.images = [];
        this.isImagesPanelVisible = false;
    }

    protected getMediaIdsFromImages(): Array<string> {
        let mediaIds = [];
        for(let index = 0; index < this.images.length; index++) {
            const img: Element = this.images[index];
            mediaIds.push(img.getAttribute('mediaId'))
        }

        return mediaIds
    }

    public save() {
        const mediaIds = this.getMediaIdsFromImages();
        this.pending = true;
        this.adminHttpClient.createGifFromMedias(mediaIds).subscribe((media: Media) => {
            this.pending = false;
            this.gifMedia = media;
        });
        return false;
    }

    public delete() {
        this.gifMedia = null;
    }
}
