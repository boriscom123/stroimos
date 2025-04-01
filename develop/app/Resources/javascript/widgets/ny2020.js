$(function () {

  var check = moment();
  var check_month = check.format('M');
  var check_day   = check.format('D');
  if ((check_month == 12 && check_day > 23) || (check_month == 1 && check_day < 8)) {
    if ($.cookie('ny2020PreviousTimeShownAt') == undefined) {
      start_ny2020();
      $.cookie('ny2020PreviousTimeShownAt', moment(), { path: '/', expires: 100 });
    } else if (moment().diff(moment($.cookie('ny2020PreviousTimeShownAt')), 'hours') > 18) {
      start_ny2020();
      $.cookie('ny2020PreviousTimeShownAt', moment(), { path: '/', expires: 100 });
    }
  }

  function start_ny2020() {
    var ny2020_is_active = true;
    var ny2020_is_closing = false;

    $('body').addClass('ny2020-active');
    $('.ny2020').addClass('ny2020_active');    

    var ny2020 = new TimelineMax(),
    ny2020_middle_tree = document.getElementById("ny2020__middle_tree"),
    ny2020_left_tree = document.getElementById("ny2020__left_tree"),
    ny2020_right_tree = document.getElementById("ny2020__right_tree"),
    ny2020_text = document.getElementById("ny2020__text");

    ny2020
      .fromTo(ny2020_middle_tree, 0.6, { opacity: 0, scale: 0, xPercent: 50, yPercent: 100 }, { scale: 1, ease: Back.easeOut.config(2), xPercent: 0, yPercent: 0, opacity: 1}, 3.8)
      .fromTo(ny2020_left_tree, 0.6, { opacity: 0, scale: 0, xPercent: 50, yPercent: 100 }, { scale: 1, ease: Back.easeOut.config(2), xPercent: 0, yPercent: 0, opacity: 1}, 3.5)
      .fromTo(ny2020_right_tree, 0.6, { opacity: 0, scale: 0, xPercent: 50, yPercent: 100 }, { scale: 1, ease: Back.easeOut.config(2), xPercent: 0, yPercent: 0, opacity: 1}, 4.1)
      .fromTo(ny2020_text, 0.6, { opacity: 0, scale: 0, xPercent: 0, yPercent: 0 }, { scale: 1, ease: Back.easeOut.config(2), xPercent: 0, yPercent: 0, opacity: 1}, 3);
      
      
    var ny2020_totalItems = 18;
    for (var i=1; i <= ny2020_totalItems; ++i) {
      var ny2020_lenght = Math.random() * (4.5 - 3) + 1;
      var ny2020_start = Math.random();    
      ny2020_hanging(ny2020_totalItems,i,ny2020_lenght,ny2020_start);
      ny2020.fromTo("#ny2020__item"+i, ny2020_lenght, {y: -(($("#ny2020__item"+i)[0].getBoundingClientRect().height)/3) }, { y: 0 }, ny2020_start)  
    };

    function ny2020_hanging(totalItems,i,lenght,start) {
      var hangOffset = 0.3;
      var hangStart = start+lenght-0.2;
      var delay = (Math.random() * 3) + 1;
      var rotation = -(( 1 / lenght ) * 3);
      ny2020.to("#ny2020__item"+i, hangOffset, {rotation: rotation, transformOrigin: "0% 0%", ease: Back.easeOut.config(2) }, hangStart/3);
      ny2020.to("#ny2020__item"+i, 10, {rotation: 0, transformOrigin: "0% 0%", ease: Elastic.easeOut.config(2.5, 0.1) }, (hangStart+hangOffset)/3);
    }		

    var ny2020_canvas = document.getElementById('ny2020__snow'),
        ny2020_ctx = ny2020_canvas.getContext('2d'),
        ny2020_width = ny2020_ctx.canvas.width = ny2020_canvas.offsetWidth,
        ny2020_height = ny2020_ctx.canvas.height = ny2020_canvas.offsetHeight,
        ny2020_animFrame = window.requestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.msRequestAnimationFrame,
        ny2020_snowflakes = [];

    $(window).resize(ny2020_resize);
  

    function ny2020_resize() {
      ny2020_width = ny2020_ctx.canvas.width = ny2020_canvas.offsetWidth;
      ny2020_height = ny2020_ctx.canvas.height = ny2020_canvas.offsetHeight;

      for (var i = 0; i < ny2020_snowflakes.length; i++) {
        ny2020_snowflakes[i].resized();
      }
    }

    window.onresize = function() {
      ny2020_width = ny2020_ctx.canvas.width = ny2020_canvas.offsetWidth;
      ny2020_height = ny2020_ctx.canvas.height = ny2020_canvas.offsetHeight;

      for (var i = 0; i < ny2020_snowflakes.length; i++) {
        ny2020_snowflakes[i].resized();
      }
    }

    function ny2020_update() {
      for (var i = 0; i < ny2020_snowflakes.length; i++) {
        ny2020_snowflakes[i].update();
      }
    }

    function ny2020_Snow() {
      this.x = ny2020_random(0, ny2020_width);
      this.y = ny2020_random(-ny2020_height, 0);
      this.radius = ny2020_random(0.5, 3.0);
      this.speed = ny2020_random(0.5, 2.0);
      this.wind = ny2020_random(-0.1, 1.0);
      this.isResized = false;

      this.updateData = function () {
        this.x = ny2020_random(0, ny2020_width);
        this.y = ny2020_random(-ny2020_height, 0);
      }

      this.resized = function () {
        this.isResized = true;
      }
		}

		ny2020_Snow.prototype.draw = function() {
			ny2020_ctx.beginPath();
			ny2020_ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI);
			ny2020_ctx.fillStyle = '#fff';
			ny2020_ctx.fill();
			ny2020_ctx.closePath();
		}

		ny2020_Snow.prototype.update = function() {
			this.y += this.speed;
			this.x += this.wind;

			if (this.y > ny2020_ctx.canvas.height) {
				if (this.isResized) {
					this.updateData();
					this.isResized = false;
				} else {
					this.y = 0;
					this.x = ny2020_random(0, ny2020_width); 
				}
			}
		}

		function ny2020_createSnow(count) {
			for (var i = 0; i < count; i++) {
				ny2020_snowflakes[i] = new ny2020_Snow();
			}
		}

		function ny2020_draw() {
			ny2020_ctx.clearRect(0, 0, ny2020_ctx.canvas.width, ny2020_ctx.canvas.height);
			for (var i = 0; i < ny2020_snowflakes.length; i++) {
				ny2020_snowflakes[i].draw();
			}
		}

		function ny2020_loop() {
			ny2020_draw();
			ny2020_update();			
      ny2020_is_active == true && ny2020_animFrame(ny2020_loop);
		}

		function ny2020_random(min, max) {
			var rand = (min + Math.random() * (max - min)).toFixed(1);
			rand = Math.round(rand);
			return rand;
		}

		ny2020_createSnow(200);
    ny2020_loop();
    
    $(window).on('click', ny2020_close);

    function ny2020_close() {
      if (!ny2020_is_closing) {
        ny2020_is_closing = true;
        $('.ny2020').fadeOut(2000);      
        setTimeout(function() {
          ny2020_is_active = false;
          $(window).off('resize', ny2020_resize);
          $(window).off('click', ny2020_close);
          $('body').removeClass('ny2020-active');
          $('.ny2020').remove();
          ny2020.kill();
        }, 2100)
      }      
    }

    setTimeout(function() {
      ny2020_close();
    }, 8000)
  }
})