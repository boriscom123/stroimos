.PHONY : reinit download_prod_mysql download_prod_media upload_video_timelaps download_prod_media_partial

reinit:
	composer install --no-scripts
	php app/console doc:sch:drop -f
	php app/console doc:sch:create
	composer install
	php app/console doc:fix:load -n
	php app/console fos:el:pop

download_prod_mysql:
	ssh str-db-2-pas-l "mysqldump --add-drop-database stroi_mos_ru_prod | gzip -c1" | gunzip | pv | mysql

download_prod_dump:
	ssh data-origin "mysqldump --single-transaction stroi_mos_ru_prod | gzip -c1" | gunzip | pv | mysql #--defaults-group-suffix=base

prod_local_dump:
	mkdir -p ../../dump
	mysqldump --single-transaction stroi_mos_ru_prod > ../../dump/backup_`date +'%y-%m-%d_%H-%M-%S'`.sql
	ls -1 ../../dump/* | head -n-3 | xargs -r rm -rf

download_prod_media:
	rsync -rlt -v --info=progress2 --exclude=video str-app-2-pas-l:/var/www/html/main/shared/web/uploads/media/ web/uploads/media/

download_prod_static:
	rsync -rlt -v -O --exclude=video data-origin:/var/www/html/main/shared/web/uploads/media/ web/uploads/media/

download_prod_media_partial:
	rsync -rlt -v --info=progress2 --exclude=video str-app-2-pas-l:/var/www/html/main/shared/web/uploads/media/gallery_media/0001/36/ web/uploads/media/gallery_media/0001/36/;\
	rsync -rlt -v --info=progress2 --exclude=video str-app-2-pas-l:/var/www/html/main/shared/web/uploads/media/gallery_media/0001/37/ web/uploads/media/gallery_media/0001/37/;\
	rsync -rlt -v --info=progress2 --exclude=video str-app-2-pas-l:/var/www/html/main/shared/web/uploads/media/main_image/0001/36/ web/uploads/media/main_image/0001/36/;\
	rsync -rlt -v --info=progress2 --exclude=video str-app-2-pas-l:/var/www/html/main/shared/web/uploads/media/main_image/0001/37/ web/uploads/media/main_image/0001/37/

upload_video_timelaps:
	rsync -rlt -v --info=progress2 --delete web/uploads/bg_timelaps gsk.beontheway.ru:/var/www/gsk.beontheway.ru/shared/web/uploads/

prod:
	grunt build
	php app/console sonata:cache:flush-all
	php app/console cache:clear --env=prod

