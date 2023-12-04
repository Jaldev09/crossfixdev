<?php
/*
 * Functionality for autoloading other PHP classes and registering the loader
 * with PHP.
 */


// Set the namespace
Namespace Wisewebs\Classes\Autoloader;


/*
 * The main class for autoloading.
 */
class Autoloader {

	const DIRECTORY_NAME__CLASSES    = "Classses";
	const DIRECTORY_NAME__INTERFACES = "Interfaces";

	const AUTOLOADER_FUNCTION_NAME   = "Wisewebs\\Classes\\Autoloader\\Autoloader::autoload";





	/**
	 * Register the autoloader for all relevant situations.
	 */
	public static function register() {

		// Register the autoloader for standard runtime
		spl_autoload_register(
			static::AUTOLOADER_FUNCTION_NAME
		);


		// Register the autoloader for WordPress' REST API init
		if ( function_exists( 'add_action' ) ) {

			add_action(
				'rest_api_init',
				function() {

					// Register the autoloader for standard runtime
					spl_autoload_register(
						static::AUTOLOADER_FUNCTION_NAME
					);
				}
			);
		}
	}





	/**
	 * Autoloads a requested class.
	 *
	 * @param      string  $requestedClass  Class to load, including namespace
	 */
	public static function autoload( $requestedClass ) {

		// Which namespace is the required file in? Explode it into an array so we can check the first part later
		$requestedNamespaceBase = explode(
			"\\",
			$requestedClass
		);

		// Did we get a "first part" from the namespace?
		$requestedNamespaceBase = (
			! empty( $requestedNamespaceBase[ 0 ] )
				? $requestedNamespaceBase[ 0 ]
				: null
		);


		// Which namespace is the required file in? Explode it into an array so we can check the first part later
		$currentNamespaceBase = explode(
			"\\",
			__NAMESPACE__
		);

		// Did we get a "first part" from the namespace?
		$currentNamespaceBase = (
			! empty( $currentNamespaceBase[ 0 ] )
				? $currentNamespaceBase[ 0 ]
				: null
		);


		// Only bother if the namespace is right
		if ( $currentNamespaceBase === $requestedNamespaceBase ) {

			// Replace backslashes with forward slashes
			$namespace = str_replace(
				"\\",
				"/",
				$requestedClass
			);

			// What seems to be the class directory? (Bear in mind that this may contain parent classes too though!)
			$namespaceWithoutTopLevel = substr(
				$namespace,
				0,
				strrpos(
					$namespace,
					DIRECTORY_SEPARATOR
				)
			);

			// What seems to be the name of the class?
			$namespaceTopLevel = pathinfo(
				$namespace,
				PATHINFO_BASENAME
			);

			// What seems to be the parent in the namespace structure?
			$namespaceParent = pathinfo(
				$namespaceWithoutTopLevel,
				PATHINFO_BASENAME
			);


			// Main class
			if ( static::DIRECTORY_NAME__CLASSES === $namespaceParent || static::DIRECTORY_NAME__INTERFACES === $namespaceParent || $namespaceParent === $namespaceTopLevel  ) {

				$includeFile = strtolower( $namespaceWithoutTopLevel . "/" . $namespaceTopLevel . ".php" );

			// Extending class
			} else {

				$includeFile = strtolower( $namespaceWithoutTopLevel . "/" . $namespaceParent . "." . $namespaceTopLevel . ".php" );
			}


			// Are we in WordPress so we can access the get_template_directory()-function?
			if ( function_exists( 'get_template_directory' ) ) {

				$baseDirectory = get_template_directory();

			// Nope, let's make an educated guess about the folder structure then
			} else {

				$baseDirectory = __DIR__ . "/../../../";
			}

			// Add the full directory structure
			$includeFile = $baseDirectory . $includeFile; // <--------------------



			// Avoid repeats of the namespacebase
			$includeFile = str_ireplace(
				$currentNamespaceBase . $currentNamespaceBase,
				$currentNamespaceBase,
				$includeFile
			);


			// Does that class exist? Then include it!
			if ( is_readable( $includeFile ) && is_file( $includeFile ) )
				require_once $includeFile;
		}
	}
}
