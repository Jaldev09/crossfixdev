<?php
/*
 * Class file for the main header.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


/**
 * Class used for the main header.
 */
class CookieBar extends Content {

	const STYLE__BAR__BG_COLOR_FALLBACK   = '#000';
	const STYLE__BAR__BG_COLOR            = 'rgba(0,0,0,.8)';
	const STYLE__BAR__TEXT_COLOR          = '#fff';
	const STYLE__BUTTON__BG_COLOR         = '#780000';
	const STYLE__BUTTON__TEXT_COLOR       = '#fff';
	const STYLE__BUTTON__TEXT_COLOR_HOVER = '#eee';


	const CSS_ID__BAR                     = 'ww-cookie-information';





	/**
	 * Prints the CSS needed to display the cookie bar
	 */
	public static function printCSS() {
?>
		<!-- START: Cookie-bar CSS -->
		<style type="text/css">#ww-cookie-information,#ww-cookie-information *{box-sizing:border-box}#ww-cookie-information{padding:5px 10px;position:fixed;bottom:-100%;left:0;z-index:999999;height:auto;width:100%;background-color:<?php echo self::STYLE__BAR__BG_COLOR_FALLBACK; ?>;background-color:<?php echo self::STYLE__BAR__BG_COLOR; ?>;-webkit-transition:bottom 1s;transition:bottom 1s;color:<?php echo self::STYLE__BAR__TEXT_COLOR; ?>;font-family:sans-serif}#ww-cookie-information.active{bottom:0}#ww-cookie-information.inactive{display:none}#ww-cookie-information .ww-wrap{display:block;margin:0 auto;max-width:1200px;width:100%;font-size:14px}#ww-cookie-information .ww-wrap button,#ww-cookie-information .ww-wrap span{display:inline-block}#ww-cookie-information .ww-wrap>span{margin-top:5px}#ww-cookie-information .ww-wrap span{width:88%}#ww-cookie-information .ww-wrap span a{color:inherit;text-decoration:underline}#ww-cookie-information .ww-wrap button{padding:4px 10px;vertical-align:top;background-color:<?php echo self::STYLE__BUTTON__BG_COLOR; ?>;border:none;border-radius:2px;cursor:pointer;font:inherit;color:<?php echo self::STYLE__BUTTON__TEXT_COLOR; ?>;font-weight:700}#ww-cookie-information .ww-wrap button:hover,#ww-cookie-information .ww-wrap span a:hover{color:<?php echo self::STYLE__BUTTON__TEXT_COLOR_HOVER; ?>}@media (max-width:1000px){#ww-cookie-information .ww-wrap{text-align:center}#ww-cookie-information .ww-wrap button{display:block;margin:10px auto 0}}</style>
		<!-- END: Cookie-bar CSS -->
<?php
	}





	/**
	 * Prints the JS necessary for the cookiebar to work
	 */
	public static function printJS() {
?>
		<!-- START: Cookie-bar JS -->
		<script type="text/javascript">function setCookie(){var e=new Date;e.setFullYear(e.getFullYear()+1),document.cookie=cookieName+"=true; expires="+e.toUTCString()+"; path=/"}var cookieName="ww_cookie_consent";if(document.cookie.indexOf(cookieName)<0){var cookieInfo=document.getElementById("ww-cookie-information"),cookieConsent=document.getElementById("ww-cookie-consent"),showDelay=100;cookieInfo.className="",setTimeout(function(){cookieInfo.className="active"},showDelay),cookieConsent.addEventListener("click",function(){setCookie(),cookieInfo.className="",setTimeout(function(){cookieInfo.className="inactive"},5e3)})}else document.cookie.indexOf(cookieName)>=0&&setCookie();</script>
		<!-- END: Cookie-bar JS -->
<?php
	}





	/**
	 * Prints the HTML used for the cookie bar
	 */
	public static function printHTML() {
?>
		<!-- START: Cookie-bar HTML -->
		<div id="<?php echo self::CSS_ID__BAR; ?>" class="inactive"><div class="ww-wrap"><span>Den här webbplatsen använder <a href="/cookies">cookies</a> för att förbättra användarupplevelsen. Genom att fortsätta använda sidan godkänner du detta.</span> <button id="ww-cookie-consent" type="button">Jag förstår!</button></div></div>
		<!-- END: Cookie-bar HTML -->
<?php
	}





	/**
	 * Utilize the magic function __set to make sure we can't overload this
	 * class.
	 *
	 * @param      string  $name   Unused, we only care to receive it for
	 *                             compatibility
	 * @param      string  $val    Unused, we only care to receive it for
	 *                             compatibility
	 */
	public function __set( $name, $val ) {

		// Hey, this is overloading! This class doesn't allow that!
		Utility\Utility::preventClassOverload();
	}
}
