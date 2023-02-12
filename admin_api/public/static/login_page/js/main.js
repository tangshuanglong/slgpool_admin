;(function () {


	'use strict';

	// Placeholder
	var placeholderFunction = function() {
		$('input, textarea').placeholder({ customClass: 'my-placeholder' });
	}

	// Placeholder
	var contentWayPoint = function() {
		var i = 0;
		$('.animate-box').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('animated-fast') ) {

				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .animate-box.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn animated-fast');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft animated-fast');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight animated-fast');
							} else {
								el.addClass('fadeInUp animated-fast');
							}

							el.removeClass('item-animate');
						},  k * 200, 'easeInOutExpo' );
					});

				}, 100);

			}

		} , { offset: '85%' } );
	};

	$(document).keyup(function(event){
		if(event.keyCode ==13){
			$("#btn_login_ok").trigger("click");
		}
	});


	// login event handle1
	var loginHandle = function() {
		$('form').on('submit', function(e) {
			var url = $(this).attr('action');
			var formdata = $(this).serialize();
			e.preventDefault();
			$.ajax({
				url: url,
				type: 'post',
				data: formdata,
				success: function(e) {
					if (e.code == 0) {
						location.href = '/admin'
					} else {
						layui.use(['layer'], function(){
							var layer = layui.layer;
							layer.msg(e.msg, {time: 1000});
						});
					}
				}
			});
		});
	};

	// On load
	$(function(){
		placeholderFunction();
		contentWayPoint();
		loginHandle();
	});

}());
