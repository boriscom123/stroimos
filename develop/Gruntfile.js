/*global module:false*/
module.exports = function (grunt) {

    /* Inline css pre-config */
    var inlinecss_files = {}
    grunt.file.recurse('app/Resources/views/Emails/src/dev/', function(abspath, rootdir, subdir, filename) {
        grunt.log.subhead('Found templates:');
        grunt.log.write(filename+'\n');
        var prod_path = 'app/Resources/views/Emails/src/prod/'+filename;
        var dev_path = 'app/Resources/views/Emails/src/dev/'+filename;
        inlinecss_files[prod_path] = dev_path;
    })

    // Project configuration.
    grunt.initConfig({
        // Metadata.
        pkg: grunt.file.readJSON('package.json'),
        banner: '/* <%= pkg.title || pkg.name %> v<%= pkg.version %> */',
        jsFile: 'web/js/<%= pkg.name %>',
        js_src_dir: 'app/Resources/javascript',
        css_src_dir: 'app/Resources/less',
        // Task configuration.
        devUpdate: {
            main: {
                options: {
                    reportUpdated: true,
                    updateType: 'prompt',
                    semver: true
                }
              }
        },
        concat: {
            main: {
                options: {
                    banner: '<%= banner %>',
                    stripBanners: true,
                    separator: '\n;'
                },
                src: [
                    '<%= js_src_dir %>/vendor/jquery/dist/jquery.min.js',
                    '<%= js_src_dir %>/vendor/jquery.cookie/jquery.cookie.js',
                    '<%= js_src_dir %>/vendor/salvattore/dist/salvattore.min.js',
                    '<%= js_src_dir %>/vendor/magnific-popup/dist/jquery.magnific-popup.min.js',
                    '<%= js_src_dir %>/vendor/bxslider-4/dist/jquery.bxslider.min.js',
                    '<%= js_src_dir %>/vendor/dotdotdot/src/js/jquery.dotdotdot.min.js',
                    '<%= js_src_dir %>/vendor/jquery-ui/jquery-ui.min.js',
                    '<%= js_src_dir %>/vendor/jquery.selectBoxIt.js/src/javascripts/jquery.selectBoxIt.min.js',
                    '<%= js_src_dir %>/vendor/slick-carousel/slick/slick.min.js',
                    '<%= js_src_dir %>/vendor/Fullscreen-API-Polyfill/fullscreen-api-polyfill.js',
                    '<%= js_src_dir %>/vendor/jquery-tree/src/js/jquery.tree.js',
                    '<%= js_src_dir %>/vendor/handlebars/handlebars.js',
                    '<%= js_src_dir %>/vendor/AnythingZoomer/dist/jquery.anythingzoomer.js',
                    '<%= js_src_dir %>/vendor/twentytwenty/js/jquery.event.move.js',
                    '<%= js_src_dir %>/vendor/twentytwenty/js/jquery.twentytwenty.js',
                    '<%= js_src_dir %>/vendor/iframe-resizer/js/iframeResizer.min.js',
                    '<%= js_src_dir %>/vendor/textfit/textFit.js',
                    '<%= js_src_dir %>/vendor/utatti-perfect-scrollbar/dist/perfect-scrollbar.js',
                    '<%= js_src_dir %>/vendor/bowser/src/bowser.js',
                    '<%= js_src_dir %>/vendor/momentjs/moment.js',
                    '<%= js_src_dir %>/vendor/jquery.eraser.js',
                    '<%= js_src_dir %>/vendor/scrollMonitor/scrollMonitor.js',
                    '<%= js_src_dir %>/vendor/chart.js/dist/Chart.min.js',
                    '<%= js_src_dir %>/vendor/chartjs-plugin-labels/build/chartjs-plugin-labels.min.js',
                    '<%= js_src_dir %>/vendor/greensock/TweenMax.min.js',
                    '<%= js_src_dir %>/vendor/greensock/DrawSVGPlugin.min.js',
                    '<%= js_src_dir %>/vendor/greensock/MorphSVGPlugin.min.js',
                    '<%= js_src_dir %>/vendor/selectize/dist/js/standalone/selectize.min.js',
                    '<%= js_src_dir %>/widgets/geocoder.js',
                    '<%= js_src_dir %>/widgets/loadmore_button.js',
                    //'<%= js_src_dir %>/widgets/background_video.js',
                    '<%= js_src_dir %>/widgets/dropdown_menu.js',
                    '<%= js_src_dir %>/widgets/photogallery.js',
                    '<%= js_src_dir %>/widgets/day_news.js',
                    '<%= js_src_dir %>/widgets/themes_panel.js',
                    '<%= js_src_dir %>/widgets/top_news.js',
                    '<%= js_src_dir %>/widgets/subscribe_form.js',
                    //'<%= js_src_dir %>/widgets/news_widget.js',
                    '<%= js_src_dir %>/widgets/comment_form.js',
                    '<%= js_src_dir %>/widgets/text_more.js',
                    '<%= js_src_dir %>/widgets/map.js',
                    '<%= js_src_dir %>/widgets/person.js',
                    '<%= js_src_dir %>/widgets/documents.js',
                    '<%= js_src_dir %>/widgets/photolenta_gallery.js',
                    '<%= js_src_dir %>/widgets/search.js',
                    '<%= js_src_dir %>/widgets/events.js',
                    '<%= js_src_dir %>/widgets/chat.js',
                    '<%= js_src_dir %>/widgets/auth.js',
                    '<%= js_src_dir %>/widgets/infographic.js',
                    '<%= js_src_dir %>/widgets/textarea_resize.js',
                    '<%= js_src_dir %>/widgets/copy.js',
                    '<%= js_src_dir %>/widgets/back_up_buttons.js',
                    '<%= js_src_dir %>/widgets/timeline_metro.js',
                    '<%= js_src_dir %>/widgets/hotline.js',
                    '<%= js_src_dir %>/widgets/construction.js',
                    '<%= js_src_dir %>/widgets/hot_news_banner.js',
                    '<%= js_src_dir %>/widgets/announcement.js',
                    '<%= js_src_dir %>/widgets/spotlight-slider.js',
                    '<%= js_src_dir %>/widgets/contact-center.js',
                    '<%= js_src_dir %>/widgets/iframe_height_fix.js',
                    //'<%= js_src_dir %>/widgets/timelapse_toggle.js',
                    '<%= js_src_dir %>/widgets/slide_banner.js',
                    '<%= js_src_dir %>/widgets/oasis.js',
                    '<%= js_src_dir %>/widgets/material_owner_link.js',
                    '<%= js_src_dir %>/widgets/subscribe_popup.js',
                    //'<%= js_src_dir %>/widgets/video_popup.js',
                    '<%= js_src_dir %>/widgets/zd_block_list.js',
                    '<%= js_src_dir %>/widgets/twentytwenty.js',
                    // '<%= js_src_dir %>/widgets/frozen_screen.js',
                    // '<%= js_src_dir %>/widgets/ny2020.js',
                    //'<%= js_src_dir %>/widgets/ny2022_lottie_animations.js',
                    '<%= js_src_dir %>/widgets/anchor_scroll.js',
                    '<%= js_src_dir %>/widgets/viewport_monitor.js',
                    '<%= js_src_dir %>/widgets/collapsable_table.js',
                    '<%= js_src_dir %>/widgets/faq_table.js',
                    '<%= js_src_dir %>/widgets/faq.js',
                    '<%= js_src_dir %>/widgets/metro.js',
                    '<%= js_src_dir %>/widgets/popup.js',
                    '<%= js_src_dir %>/widgets/district-selector.js',
                    //'<%= js_src_dir %>/widgets/livesignal.js',
                    '<%= js_src_dir %>/widgets/zoomer.js',
                    '<%= js_src_dir %>/widgets/doc_kpi.js',
                    '<%= js_src_dir %>/widgets/ossig_form.js',
                    '<%= js_src_dir %>/widgets/cookie_alert.js',
                    '<%= js_src_dir %>/homepage.js'
                ],
                dest: '<%= jsFile %>.js'
            },
            subordinate: {
                options: {
                    banner: '<%= banner %>',
                    stripBanners: true,
                    separator: '\n;'
                },
                src: [
                    '<%= js_src_dir %>/vendor/jquery/dist/jquery.min.js',
                    '<%= js_src_dir %>/vendor/jquery.cookie/jquery.cookie.js',
                    '<%= js_src_dir %>/vendor/salvattore/dist/salvattore.min.js',
                    '<%= js_src_dir %>/vendor/magnific-popup/dist/jquery.magnific-popup.min.js',
                    '<%= js_src_dir %>/vendor/bxslider-4/dist/jquery.bxslider.min.js',
                    '<%= js_src_dir %>/vendor/dotdotdot/src/js/jquery.dotdotdot.min.js',
                    '<%= js_src_dir %>/vendor/jquery-ui/jquery-ui.min.js',
                    '<%= js_src_dir %>/vendor/jquery.selectBoxIt.js/src/javascripts/jquery.selectBoxIt.min.js',
                    '<%= js_src_dir %>/vendor/slick-carousel/slick/slick.min.js',
                    '<%= js_src_dir %>/vendor/Fullscreen-API-Polyfill/fullscreen-api-polyfill.js',
                    '<%= js_src_dir %>/vendor/jquery-tree/src/js/jquery.tree.js',
                    '<%= js_src_dir %>/vendor/handlebars/handlebars.js',
                    '<%= js_src_dir %>/vendor/AnythingZoomer/dist/jquery.anythingzoomer.js',
                    '<%= js_src_dir %>/vendor/twentytwenty/js/jquery.event.move.js',
                    '<%= js_src_dir %>/vendor/twentytwenty/js/jquery.twentytwenty.js',
                    '<%= js_src_dir %>/vendor/iframe-resizer/js/iframeResizer.min.js',
                    '<%= js_src_dir %>/vendor/textfit/textFit.js',
                    '<%= js_src_dir %>/vendor/utatti-perfect-scrollbar/dist/perfect-scrollbar.js',
                    '<%= js_src_dir %>/vendor/bowser/src/bowser.js',
                    '<%= js_src_dir %>/vendor/momentjs/moment.js',
                    '<%= js_src_dir %>/vendor/jquery.eraser.js',
                    '<%= js_src_dir %>/vendor/scrollMonitor/scrollMonitor.js',
                    '<%= js_src_dir %>/vendor/chart.js/dist/Chart.min.js',
                    '<%= js_src_dir %>/vendor/chartjs-plugin-labels/build/chartjs-plugin-labels.min.js',
                    '<%= js_src_dir %>/vendor/selectize/dist/js/standalone/selectize.min.js',
                    '<%= js_src_dir %>/widgets/geocoder.js',
                    '<%= js_src_dir %>/widgets/loadmore_button.js',
                    //'<%= js_src_dir %>/widgets/background_video.js',
                    '<%= js_src_dir %>/widgets/dropdown_menu_subordinate.js',
                    '<%= js_src_dir %>/widgets/photogallery.js',
                    '<%= js_src_dir %>/widgets/day_news_subordinate.js',
                    '<%= js_src_dir %>/widgets/themes_panel.js',
                    '<%= js_src_dir %>/widgets/top_news.js',
                    '<%= js_src_dir %>/widgets/subscribe_form.js',
                    '<%= js_src_dir %>/widgets/comment_form.js',
                    '<%= js_src_dir %>/widgets/text_more.js',
                    '<%= js_src_dir %>/widgets/map.js',
                    '<%= js_src_dir %>/widgets/person.js',
                    '<%= js_src_dir %>/widgets/documents.js',
                    '<%= js_src_dir %>/widgets/photolenta_gallery.js',
                    '<%= js_src_dir %>/widgets/search.js',
                    '<%= js_src_dir %>/widgets/events.js',
                    '<%= js_src_dir %>/widgets/chat.js',
                    '<%= js_src_dir %>/widgets/auth.js',
                    '<%= js_src_dir %>/widgets/infographic.js',
                    '<%= js_src_dir %>/widgets/textarea_resize.js',
                    '<%= js_src_dir %>/widgets/copy.js',
                    '<%= js_src_dir %>/widgets/back_up_buttons.js',
                    '<%= js_src_dir %>/widgets/timeline_metro.js',
                    '<%= js_src_dir %>/widgets/hotline.js',
                    '<%= js_src_dir %>/widgets/construction.js',
                    '<%= js_src_dir %>/widgets/hot_news_banner.js',
                    '<%= js_src_dir %>/widgets/announcement.js',
                    '<%= js_src_dir %>/widgets/spotlight-slider.js',
                    '<%= js_src_dir %>/widgets/iframe_height_fix.js',
                    '<%= js_src_dir %>/widgets/timelapse_toggle.js',
                    '<%= js_src_dir %>/widgets/slide_banner.js',
                    '<%= js_src_dir %>/widgets/subordinate_banner.js',
                    '<%= js_src_dir %>/widgets/oasis.js',
                    '<%= js_src_dir %>/widgets/material_owner_link.js',
                    '<%= js_src_dir %>/widgets/subscribe_popup.js',
                    //'<%= js_src_dir %>/widgets/video_popup.js',
                    '<%= js_src_dir %>/widgets/zd_block_list.js',
                    '<%= js_src_dir %>/widgets/twentytwenty.js',
                    // '<%= js_src_dir %>/widgets/frozen_screen.js',
                    //'<%= js_src_dir %>/widgets/ny2022_lottie_animations.js',
                    '<%= js_src_dir %>/widgets/anchor_scroll.js',
                    '<%= js_src_dir %>/widgets/viewport_monitor.js',
                    '<%= js_src_dir %>/widgets/collapsable_table.js',
                    '<%= js_src_dir %>/widgets/faq_table.js',
                    '<%= js_src_dir %>/widgets/faq.js',
                    '<%= js_src_dir %>/widgets/metro.js',
                    '<%= js_src_dir %>/widgets/popup.js',
                    '<%= js_src_dir %>/widgets/district-selector.js',
                    //'<%= js_src_dir %>/widgets/livesignal.js',
                    '<%= js_src_dir %>/widgets/scrollbar.js',
                    '<%= js_src_dir %>/widgets/zoomer.js',
                    '<%= js_src_dir %>/widgets/doc_kpi.js',
                    '<%= js_src_dir %>/widgets/banner_subordinate.js',
                    '<%= js_src_dir %>/homepage.js'
                ],
                dest: '<%= jsFile %>_subordinate.js'

            }
        },
        uglify: {
            main: {
                options: {
                    banner: '<%= banner %>',
                    sourceMap: true
                },
                dist: {
                    src: '<%= jsFile %>.js',
                    dest: '<%= jsFile %>.min.js'
                }
            },
            subordinate: {
                options: {
                    banner: '<%= banner %>',
                    sourceMap: true
                },
                dist: {
                    src: '<%= jsFile %>_subordinate.js',
                    dest: '<%= jsFile %>_subordinate.min.js'
                }
            }
        },
        "bower-install-simple": {
            options: {
                color: true,
                directory: "<%= js_src_dir %>/vendor"
            },
            "prod": {
                options: {
                    production: true
                }
            },
            "dev": {
                options: {
                    production: false
                }
            }
        },
        less: {
            production: {
                options: {
                    paths: ['<%= css_src_dir %>'],
                    compress: true,
                    sourceMap: true,
                    plugins: [ new (require('less-plugin-autoprefix'))({browsers: [ 'last 5 versions' ]}) ]
                },
                files: [
                    {
                        src: [
                            '<%= css_src_dir %>/main.less'
                        ],
                        dest: 'web/css/<%= pkg.name %>.css'
                    },
                    {
                        src: [
                            '<%= css_src_dir %>/main_subordinate.less'
                        ],
                        dest: 'web/css/<%= pkg.name %>_subordinate.css'
                    },
                    {
                        src: [
                            '<%= css_src_dir %>/ckeditor.less'
                        ],
                        dest: 'web/css/admin/ckeditor.css'
                    }
                ]
            }
        },
        watch: {
            configFiles: {
                files: [ 'Gruntfile.js'],
                tasks: ['build'],
                options: {
                    reload: true
                }
            },
            js: {
                files: ['<%= js_src_dir %>/**/*.js'],
                tasks: ['javascript']
            },
            css: {
                files: ['<%= css_src_dir %>/**/*.{less, css}'],
                tasks: ['less']
            }
        },
        inlinecss: {
          main: {
              options: {
                webResources: {
                  images: false
                }
              },
              files: inlinecss_files
          }
        }
    });

    // These plugins provide necessary tasks.

    require('load-grunt-tasks')(grunt);

    grunt.registerTask('javascript', ['concat', 'uglify']);
    grunt.registerTask('build', [ 'bower-install-simple', 'javascript', 'less']);
    grunt.registerTask('build-templates', ['inlinecss']);
    grunt.registerTask('default', ['build', 'watch']);

};
