/** 
 *
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

(function ($) {
	"use strict";
	var YOLOSwitchStyleSelector = {
		htmlTag: {
			wrapper: '#switch-style-selector'
		},
		vars: {
			isLoading: false
		},
		initialize: function () {
			YOLOSwitchStyleSelector.build();
		},
		build: function () {
			$.ajax({
				type: 'POST',
				data: 'action=switch_selector',
				url: yolo_framework_ajax_url,
				success: function (html) {
					$('body').append(html);
					YOLOSwitchStyleSelector.events();
				},
				error: function (html) {

				}
			});
		},
		events: function () {
			$('.switch-selector-open', YOLOSwitchStyleSelector.htmlTag.wrapper).click(function () {
				$('.switch-wrapper', YOLOSwitchStyleSelector.htmlTag.wrapper).toggleClass('in');
			});

			YOLOSwitchStyleSelector.layout();
			YOLOSwitchStyleSelector.background();
			YOLOSwitchStyleSelector.reset();
			YOLOSwitchStyleSelector.primary_color();

		},
		layout: function () {

			if ( yoloGetCookie( 'yolo_layout' ) ) {
				$('body').addClass('boxed');
			} else {
				$('.switch-selector-section.switch-background').hide();
			}

			if ($('body').hasClass('boxed')) {
				$('a[data-value="boxed"]', YOLOSwitchStyleSelector.htmlTag.wrapper).addClass('active');
			} else {
				$('a[data-value="wide"]', YOLOSwitchStyleSelector.htmlTag.wrapper).addClass('active');
			}

			$('a[data-type="layout"]', YOLOSwitchStyleSelector.htmlTag.wrapper).click(function (event) {
				event.preventDefault();

				$('a[data-type="layout"]', YOLOSwitchStyleSelector.htmlTag.wrapper).removeClass('active');
				$(this).addClass('active');

				var layout = $(this).attr('data-value');
				if (layout == 'boxed') {
					$('body').addClass('boxed');
					yoloSetCookie('yolo_layout', layout, 0.02);
					$('.switch-selector-section.switch-background').fadeIn();
				} else {
					$('body').removeClass('boxed');
					yoloSetCookie('yolo_layout', layout, -1);
					$('.switch-selector-section.switch-background').fadeOut();
				}
				$('#yolo-content-wrapper').trigger(jQuery.Event('resize'));
			})

		},
		background: function () {
			if ( yoloGetCookie( 'yolo_background' ) ) {
				$('body').css({
					'background-image': 'url(' + yolo_framework_theme_url + '/assets/images/theme-options/' + yoloGetCookie( 'yolo_background' ) + ')',
					'background-repeat': 'repeat',
					'background-position': 'center center',
					'background-attachment': 'scroll',
					'background-size': 'auto'
				});
				$('ul.switch-primary-background li', YOLOSwitchStyleSelector.htmlTag.wrapper).removeClass('active');
				$('[data-type="pattern"]').each(function(){
					if ( $(this).data('name') == yoloGetCookie( 'yolo_background' ) ) {
						$(this).addClass('active');
					}
				});
			}
			$('.switch-primary-background li', YOLOSwitchStyleSelector.htmlTag.wrapper).click(function (event) {
				event.preventDefault();
				var name = $(this).data('name');
				var type = $(this).data('type');
				yoloSetCookie( 'yolo_background', name, 0.02 );

				$('body').css({
					'background-image': 'url(' + yolo_framework_theme_url + '/assets/images/theme-options/' + name + ')',
					'background-repeat': 'repeat',
					'background-position': 'center center',
					'background-attachment': 'scroll',
					'background-size': 'auto'
				});

				$('ul.switch-primary-background li', YOLOSwitchStyleSelector.htmlTag.wrapper).removeClass('active');
				$(this).addClass('active');

			})
		},
		primary_color: function () {
			if ( yoloGetCookie('yolo_primary_color') ) {
				$('ul.switch-primary-color li').removeClass('active');
				$('ul.switch-primary-color li').each(function(){
					if ( $(this).data('color') == yoloGetCookie('yolo_primary_color') ) {
						$(this).addClass('active');
					}
				});
			}
			$('ul.switch-primary-color li', YOLOSwitchStyleSelector.htmlTag.wrapper).click(function (event) {
				event.preventDefault();
				var $this = $(this);
				if (YOLOSwitchStyleSelector.vars.isLoading) return;
				YOLOSwitchStyleSelector.vars.isLoading = true;
				var color = $(this).data('color');
				$.ajax({
					url: yolo_framework_ajax_url,
					data: {
						action: 'custom_css_selector',
						primary_color: color
					},
					success: function (response) {
						yoloSetCookie( 'yolo_primary_color', color, 0.02 );
						YOLOSwitchStyleSelector.vars.isLoading = false;

						$('ul.switch-primary-color li', YOLOSwitchStyleSelector.htmlTag.wrapper).removeClass('active');
						$this.addClass('active');

						if ($('style#color_switch').length == 0) {
							$('head').append('<style type="text/css" id="color_switch"></style>');
						}

						$('style#color_switch').html(response);
					},
					error: function () {
						YOLOSwitchStyleSelector.vars.isLoading = false;
					}
				});

			});
		},
		reset: function () {
			$('#switch-selector-reset', YOLOSwitchStyleSelector.htmlTag.wrapper).click(function (event) {
				event.preventDefault();
				yoloSetCookie('yolo_background', '' , -1);
				yoloSetCookie('yolo_layout', '', -1);
				yoloSetCookie('yolo_primary_color', '', -1);
				document.location.reload(true);
			})
		}
	};

	$(document).ready(function () {
		YOLOSwitchStyleSelector.initialize();
		$("div").click(function(){
			if ( !($(this).closest(".switch-wrapper").hasClass('in')) ) {
				$('.switch-wrapper').removeClass('in');
			}
		});
	});

	// Set cookie
	function yoloSetCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		console.log(expires);
		document.cookie = cname + "=" + cvalue + ';' + expires + ";path=/";
	}

	// Get cookie
	function yoloGetCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
		}
		return "";
	}
})(jQuery);