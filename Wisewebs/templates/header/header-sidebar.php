<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

$yolo_options = yolo_get_options();

$prefix = 'yolo_';

$header_class = array('yolo-main-header', 'header-sidebar', 'header-desktop-wrapper');

$header_layout_float = get_post_meta(get_the_ID(),$prefix . 'header_layout_float',true);
if (($header_layout_float === '') || ($header_layout_float == '-1')) {
	$header_layout_float = $yolo_options['header_layout_float'];
}
if ($header_layout_float == '1') {
	$header_class[] = 'header-float';
}

$header_nav_wrapper = array('yolo-header-nav-wrapper');

$header_sticky = get_post_meta(get_the_ID(),$prefix . 'header_sticky',true);
if (($header_sticky === '') || ($header_sticky == '-1')) {
	$header_sticky = $yolo_options['header_sticky'];
}
if ($header_sticky == '1') {
	$header_nav_wrapper[] = 'header-sticky';
	$header_sticky_scheme = isset($yolo_options['header_sticky_scheme']) ? $yolo_options['header_sticky_scheme'] : 'inherit';
	$header_nav_wrapper[] = 'sticky-scheme-' . $header_sticky_scheme;
}

$header_nav_separate = get_post_meta(get_the_ID(),$prefix . 'header_nav_separate',true);
if (($header_nav_separate == '') || ($header_nav_separate == '-1')) {
	$header_nav_separate = isset($yolo_options['header_nav_separate']) && !empty($yolo_options['header_nav_separate'])
		? $yolo_options['header_nav_separate'] : '0';
}

$header_nav_hover = isset($yolo_options['header_nav_hover']) && !empty($yolo_options['header_nav_hover'])
	? $yolo_options['header_nav_hover'] : 'nav-hover-primary';

$header_nav_wrapper[] = $header_nav_hover;

$page_menu = get_post_meta(get_the_ID(),$prefix . 'page_menu',true);

$header_nav_inner_class = array('container');
$header_nav_layout = get_post_meta(get_the_ID(),$prefix . 'header_nav_layout',true);
if (($header_nav_layout == '-1') || ($header_nav_layout === '')) {
	$header_nav_layout = isset($yolo_options['header_nav_layout']) ? $yolo_options['header_nav_layout'] : '';
}
if ($header_nav_layout == 'nav-fullwith') {
	$header_nav_wrapper[] = $header_nav_layout;
}
?>
<header id="yolo-header" class="<?php echo join(' ', $header_class) ?>">
	<div class="vertical-header-wrapper">
		<!-- Top custom navigation (left) -->
		<div class="ft">
			<?php yolo_get_template('header/header-customize-left' ); ?>
		</div>
		<div class="header-top">
			<?php yolo_get_template('header/header-logo' ); ?>
		</div>
		<!-- Bottom custom navigation (right) -->
		<div class="fb">
			<?php yolo_get_template('header/header-customize-right' ); ?>
		</div>
		<div class="header-bottom">
			<?php if (has_nav_menu('primary')) : ?>
				<div id="primary-menu" class="menu-wrapper">
					<?php
					$arg_menu = array(
						'menu_id'        => 'main-menu',
						'container'      => '',
						'theme_location' => 'primary',
						'menu_class'     => 'yolo-main-menu nav-collapse navbar-nav vertical-megamenu' . ($header_nav_separate == '1' ? ' nav-separate' : ''),
						'fallback_cb'    => 'please_set_menu',
						'walker'         => new Yolo_MegaMenu_Walker()
					);
					if (!empty($page_menu)) {
						$arg_menu['menu'] = $page_menu;
					}
					wp_nav_menu( $arg_menu );
					?>
				</div>
			<?php endif; ?>
			<?php yolo_get_template('header/header-customize-nav' ); ?>
		</div>
	</div>
</header>