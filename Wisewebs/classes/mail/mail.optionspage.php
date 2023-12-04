<?php
/**
 * Functionality for configuring email settings.
 */

// Set the namespace
Namespace Wisewebs\Classes\Mail;


// Import relevant namespaces
Use Wisewebs\Interfaces;
Use Wisewebs\Classes\Utility;
Use Wisewebs\Classes\REST;
Use Exception;


/**
 * Main class for configuring email settings.
 */
abstract class OptionsPage extends Mail implements Interfaces\WordPress\OptionsPages, Interfaces\REST\Routes {

	// Class constants
	const PAGE__TITLE                 = 'Epostinställningar';
	const PAGE__META_TITLE            = self::PAGE__TITLE;
	const PAGE__SLUG                  = 'epostinstallningar';

	const REST_ROUTE__SEND_TEST_EMAIL = 'sendtestemail';

	const TEST_MAIL__RECEIVER         = 'support@wiseweb.se';
	const TEST_MAIL__TITLE            = 'Testmail från epostinställningssida';
	const TEST_MAIL__MESSAGE          = 'Kommer det här fram så fungerar SMTP-inställningarna bra.';





	/**
	 * Register the options page so we can activate/deactivate it with a single
	 * function call.
	 */
	public static function registerOptionsPage() {

		if ( function_exists( 'is_admin' ) && is_admin() ) {

			if ( function_exists( 'add_action' ) ) {

				add_action(
					'admin_menu',
					__CLASS__ . '::addPluginPage'
				);
			}
		}
	}





	/**
	 * Adds a menu item for the options page.
	 */
	public static function addPluginPage() {

		// This page will be under "Settings"
		add_options_page(
			static::PAGE__META_TITLE,
			static::PAGE__TITLE,
			'manage_options',
			static::PAGE__SLUG,
			__CLASS__ . '::createAdminPage'
		);
	 }





	/**
	 * Create the actual admin page.
	 */
	public static function createAdminPage() {
?>
		<div class="wrap">
			<h1><?php echo static::PAGE__TITLE; ?></h1>

			<p>Dessa inställningar konfigureras i direkt i filerna för att de ska följa med via Git i autodeploy och ev. Git-patch deployments utan att du behöver redigera i databasen. Du hittar dem i klassen <strong>Wisewebs\Classes\Mail\Mail</strong>.</p>

			<div class="setting sender">
				<div class="label">Avsändaradress</div>
				<div class="value"><?php echo static::$SMTPUsername; ?></div>
			</div>

			<div class="setting host">
				<div class="label">Värd</div>
				<div class="value"><?php echo static::$SMTPHost; ?></div>
			</div>

			<div class="setting port">
				<div class="label">Port</div>
				<div class="value"><?php echo static::$SMTPPort; ?></div>
			</div>

			<div class="setting protocol">
				<div class="label">Protokoll</div>
				<div class="value"><?php echo static::$SMTPSecure; ?></div>
			</div>

			<div class="setting testmail-receiver">
				<div class="label">Mottagare av testmail</div>
				<div class="value"><?php echo static::TEST_MAIL__RECEIVER; ?></div>
			</div>

			<button type="button" id="send-ww-test-mail" class="button button-primary">Skicka testmail</button>
			<div id="mail-result-pane"></div>
		</div>
<?php
	}





	/**
	 * Register routes for the REST API.
	 */
	public static function registerRESTRoutes() {

		if ( function_exists( 'add_action' ) ) {

			add_action(
				'rest_api_init',
				function () {
					register_rest_route(
						REST\REST::ROUTE__BASE . "/" . REST\REST::ROUTE__CURRENT_VERSION,
						"/" . static::REST_ROUTE__SEND_TEST_EMAIL,
						Array(
							"methods"  => "POST",
							"callback" => __CLASS__ . "::sendTestEmail",
						)
					);
				}
			);
		}
	}




	/**
	 * Sends a test email and print debugging information if it fails.
	 *
	 * @throws     Exception  Returns a false status and error info if available
	 *
	 * @return     Array      Return the status of the call and any related data
	 */
	public static function sendTestEmail() {

		try {

			// Make sure we're logged in before using this function
			if ( ! is_user_logged_in() )
				throw new Exception(
					REST\REST::ERROR_MESSAGE__LOGGED_OUT,
					REST\REST::ERROR_CODE__LOGGED_OUT
				);


			// Try to send the test mail
			$result = wp_mail(
				static::TEST_MAIL__RECEIVER,
				static::TEST_MAIL__TITLE,
				static::TEST_MAIL__MESSAGE
			);

			// Did it go well? (Keep this as a loose comparison since it returns 1)
			if ( true == $result ) {

				return Array(
					'result' => true,
				);

			// Didn't go well...
			} else {

				$mailError = "";

				// Check if we've got PHPMailer data in globals as 'wp_mail()' doesn't want to return any useful data
				if ( ! empty( $GLOBALS[ 'phpmailer' ] ) ) {

					// Set it to a custom variable so we can modify it
					$mailError = $GLOBALS[ 'phpmailer' ];

					// Overwrite the password so we don't send it along (not that it would matter since it's in a logged in capacity, but still)
					$mailError->Password = "*Removed from response as it's sensitive information*";
				}

				return Array(
					'status' => false,
					'data'   => $mailError,
				);
			}

		} catch ( Exception $e ) {

			return Array(
				'status' => false,
				'error'  => Array(
					'code'    => $e->getCode(),
					'message' => $e->getMessage(),
 				)
			);
		}
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
