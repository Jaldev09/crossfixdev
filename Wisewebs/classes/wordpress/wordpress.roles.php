<?php
/*
 * Functionality related to Wordpress' roles.
 */


// Set the namespace
Namespace Wisewebs\Classes\WordPress;
// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * The main class for managin Wordpress' roles things.
 */
class Roles extends WordPress
{
	/*----------  Functionality  ----------*/

	const DEFAULT__USER_ROLE_BASE = 'administrator';



	/*----------  Dynamic variables  ----------*/

	public $slug;
	public $name;





	/**
	 * Set up a user role with WordPress.
	 */
	public function setupUserRole()
	{
		// Access the global roles object
		global $wp_roles;


		// Verify that data is available
		if ( ! empty( $this->slug ) && ! empty( $this->name ) )
		{
			// If the global roles object isn't accessible
			if ( ! isset( $wp_roles ) )
			{
				// Instantiate it anew
				$wp_roles = new WP_Roles();
			}

			// Get the administrator role
			$AdminRole = $wp_roles->get_role( static::DEFAULT__USER_ROLE_BASE );


			// Add our new role
			$wp_roles->add_role(
				$this->slug,
				$this->name,
				$AdminRole->capabilities
			);
		}
	}





	/**
	 * Register a new role with WordPress
	 *
	 * @param      string  $slug   Slug to use for the role
	 * @param      string  $name   Name to use for the role
	 */
	public static function registerUserRole( $slug, $name )
	{
		// Instantiate a new of current object
		$Role = new static();

		// Set slug
		$Role->slug = $slug;

		// Set name
		$Role->name = $name;


		// Setup our new role on WP init
		add_action(
			'init',
			array(
				$Role,
				'setupUserRole'
			)
		);
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
	public function __set( $name, $val )
	{
		// Hey, this is overloading! This class doesn't allow that!
		Utility\Utility::preventClassOverload();
	}
}
