<?php
/**
 * Functionality for configuring email settings.
 */

// Set the namespace
Namespace Wisewebs\Classes\Mail;


// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/**
 * Main class for configuring email settings.
 */
abstract class Mail {


	// Class constants
	const SMTP__PORT__SSL           = 465;
	const SMTP__PORT__TLS           = 587;
	const SMTP__AUTH                = true;
	const SMTP__PROTOCOL_NAME__SSL  = 'ssl';
	const SMTP__PROTOCOL_NAME__TLS  = 'tls';


	// Site specific settings
	protected static $SMTPHost     = 'send.one.com';
	protected static $SMTPUsername = 'order@crossfix.se';
	protected static $SMTPPassword = 'wSNa&D2CF';
	protected static $SMTPPort     = self::SMTP__PORT__SSL;
	protected static $SMTPAuth     = self::SMTP__AUTH;
	protected static $SMTPSecure   = self::SMTP__PROTOCOL_NAME__SSL;






	/**
	 * Run the necessary functions to configure SMTP
	 */
	public static function configureSMTP() {

		if ( function_exists( 'add_action' ) ) {

			add_action(
				'phpmailer_init',
				__CLASS__ . '::WPSMTP'
			);
		}
	}





	/**
	 * Setup SMTP for WordPress specifically.
	 *
	 * @param      \PHPMailer  $PHPMailer  The PHPMailer object set up by
	 *                                     WordPress
	 */
	public static function WPSMTP( \PHPMailer\PHPMailer\PHPMailer $PHPMailer ) {

		// Basic SMTP authentication
		$PHPMailer->Host       = static::$SMTPHost;
		$PHPMailer->Username   = static::$SMTPUsername;
		$PHPMailer->Password   = static::$SMTPPassword;
		$PHPMailer->Port       = static::$SMTPPort;
		$PHPMailer->SMTPAuth   = static::$SMTPAuth;
		$PHPMailer->SMTPSecure = static::$SMTPSecure;

		// Make sure we set the sender to the actual sender...
		$PHPMailer->From       = static::$SMTPUsername;

		// Tell PHPMailer that we're now using SMTP
		$PHPMailer->IsSMTP();
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
		Utility\Main::preventClassOverload();
	}
}
