<?php
/*
 * Generic AJAX-functionality.
 */


// Set the namespace
Namespace Wisewebs\Classes\AJAX;

// Import relevant namespaces
Use Wisewebs\Classes\Utility;
Use \Exception;


/*
 * The main class for handling AJAX-requests.
 */
class AJAX {

	const OUTPUT_STATUS_NAME                  = 'status';
	const OUTPUT_STATUS_ERROR                 = false;
	const OUTPUT_STATUS_OK                    = true;
	const OUTPUT_INFORMATION_NAME             = 'data';
	const OUTPUT_BUFFERED_PHP_NAME            = 'buffer';

	const ERROR_CODE_MISSING_DATA             = 1;
	const ERROR_CODE_INVALID_INPUT            = 2;
	const ERROR_CODE_ACTION_ALREADY_PERFORMED = 3;



	/**
	 * Things needed to prepare for the AJAX-request and initial functionality.
	 *
	 * @param      boolean  $formatData  Do we want to format input data right
	 *                                   away?
	 */
	public static function initAjax( $formatData = true ) {

		// Start an output buffer so we can make sure all the data returned is as sent by us (This does not include PHP-errors as those are processed in a shutdown function)
		ob_start();

		// Process all input
		self::formatInputData( $_POST );
		self::formatInputData( $_GET );
	}




	/**
	 * Verify that critical data was sent and received. Data structure is
	 * ignored, only whether data is present is verified.
	 *
	 *
	 * Do NOT: Use this function to check if we have all input from forms (Since
	 * checkboxes, for instance, send 1 or nothing) or other non-critical data.
	 *
	 * DO: Use this function for absolutely vital data which we cannot proceed
	 * without.
	 *
	 * @param      Array  $args   Function arguments
	 */
	public static function requireData( $args = Array() ) {

		try {

			// Default arguments
			$defaults = Array(
				'post' => Array(),
				'get'  => Array(),
			);

			// Replace defaults with user args where applicable
			$data = array_replace_recursive(
				$defaults,
				$args
			);

			// Check thata all post data is present
			foreach ( $data as $requestType => $values ) {

				// Make sure only the types we define are being used here
				if ( !array_key_exists( $requestType, $defaults ) )
					throw new Exception(
						'Only pre-defined request types are allowed',
						self::ERROR_CODE_INVALID_INPUT
					);


				// Make sure we got an array of values to check
				if ( !is_array( $values ) )
					throw new Exception(
						'Incorrect type provided in function arguments',
						self::ERROR_CODE_INVALID_INPUT
					);


				// Can we access this more dynamically somehow in the future? (With something like ${ '_' . strtoupper( $requestType ) }[ '' ] or similar)
				$requestData = (
					$requestType === 'post'
						? $_POST
						: $_GET
				);


				// Loop the values
				foreach ( $values as $value )
					// Check that the value isn't empty
					if ( empty( $requestData[ $value ] ) )
						throw new Exception(
							strtoupper( $requestType ) . ' parameter: \'' . $value . '\' is missing and has been registered as critically necessary',
							self::ERROR_CODE_MISSING_DATA
						);

			}

		} catch ( Exception $e ) {

			// We didn't have all the data necessary for this, so end it immediately
			self::endAjax(
				self::OUTPUT_STATUS_ERROR,
				Array(
					'error' => Array(
						'message' => $e->getMessage(),
						'code'    => $e->getCode(),
					)
				)
			);
		}
	}





	/**
	 * Format user input to avoid unnecessary spaces etc. being an issue.
	 *
	 * WARNING: Modifies existing variable instead of returning data.
	 *
	 * @param      Array  $input  The input we need to format
	 */
	public static function formatInputData( &$input = Array() ) {

		// Make sure there is input in this array before doing anything
		if ( !empty( $input ) && is_array( $input ) )
			array_walk_recursive(
				$input,
				function ( &$value ) {

					// Remove leading and trailing spaces
					$value = trim( $value );
				}
			);
	}





	/**
	 * Format the return data so we get a standardised data structure.
	 *
	 * @param      Array|string|Object|integer  $data   The data to process
	 *
	 * @return     array   Processed data
	 */
	public static function formatReturnData( $data = null ) {

		// Make sure we have something to process
		if ( !empty( $data ) ) {

			// Cast to array before doing anything else
			$data = ( Array )$data;

			// Instantiate a new array as we cannot properly walk the array we're modyfying keys in
			$processedData = array();

			// Loop the data array
			foreach ( $data as $key => $value )
				// Convert keys to camelcase and process any nested arrays
				$processedData[ Utility\Strings::convertToCamelcase( $key ) ] =
					is_array( $value )
						? self::formatReturnData( $value )
						: $value;

			// Return the processed data
			return $processedData;
		}
	}





	/**
	 * Ends the AJAX call. Run this at the end of all your AJAX calls.
	 *
	 * @param      string                       $status  The status of the
	 *                                                   AJAX-call as a whole
	 *                                                   (Defaults to error)
	 * @param      Array|string|Object|integer  $data    Additional information
	 *                                                   (Optional)
	 */
	public static function endAjax( $status = self::OUTPUT_STATUS_ERROR, $data = null ) {

		// Instantiate output as an array
		$output = Array();

		// Set status to
		$output[ self::OUTPUT_STATUS_NAME ] = $status;

		// If theres any data to be printed, add that too
		if ( !empty( $data ) )
			$output[ self::OUTPUT_INFORMATION_NAME ] = self::formatReturnData( $data );

		// Get any output PHP actually pushed without our explicit approval
		$output[ self::OUTPUT_BUFFERED_PHP_NAME ] = ob_get_clean();

		// JSON-encode it so we can process this with JS later
		$output = json_encode(
			$output
		);

		// Print it out
		echo $output;

		// And stop the script. We're done here.
		die();
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
