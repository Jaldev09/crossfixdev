<?php
/*
 * Functionality related to Wordpress menus.
 */


// Set the namespace
Namespace Wisewebs\Classes\WordPress;
// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * The main class for Woocommerce-related things.
 */
class Menus extends WordPress {

	// Class constants
	const SETTING__MAX_MENU_DEPTH = 3;



	/**
	 * Allow filtering on specific menu items by parent.
	 *
	 * Adapted from:
	 * http://wordpress.stackexchange.com/questions/2802/display-a-portion-branch-of-the-menu-tree-using-wp-nav-menu/2809#2809
	 *
	 * @param      Array  $items  Items in menu
	 * @param      Array  $args   Function arguments
	 *
	 * @return     Array  Filtered menu item list
	 */
	public static function allowFilteringByMenuItem( $items, $args ) {

		// Make sure a filter is set, otherwise we'll just return it as is
		if ( !empty( $args->parent ) ) {

			// Are we using an ID or a title for filtering?
			$filterKey = (
				is_numeric( $args->parent )
					? 'object_id'
					: 'title'
			);

			$filterArgs =
			[
				$filterKey => $args->parent,
			];

			if ( ! empty( $args->object ) )
			{
				$filterArgs[ 'object' ] = $args->object;
			}

			// Get an object of the selected parent item
			$selectedParent = wp_filter_object_list(
				$items,
				$filterArgs,
				'and',
				'ID'
			);

			// 
			$selectedParent = array_pop(
				$selectedParent
			);

			// Get the children of the current menu link
			$children = static::getChildrenIDs(
				$selectedParent,
				$items
			);

			// Loop items in menu
			foreach( $items as $key => $item ) {

				// If it doesn't belong to the selected item
				if ( !in_array( $item->ID, $children ) ) {

					// Unset it
					unset(
						$items[ $key ]
					);
				}
			}
		}

		// Always return items
		return $items;
	}





	/**
	 * Gets the children IDs of a specific menu item.
	 *
	 * @param      integer  $id     The ID of the parent
	 * @param      Array    $items  List of menu items
	 *
	 * @return     Array    The children IDs.
	 */
	public static function getChildrenIDs( $id, $items ) {

		// Get an object for the current link
		$ids = wp_filter_object_list(
			$items,
			array(
				'menu_item_parent' => $id
			),
			'and',
			'ID'
		);

		// Loop IDs
		foreach( $ids as $id ) {

			// Get the children of the current menu link
			$ids = array_merge(
				$ids,
				static::getChildrenIDs(
					$id,
					$items
				)
			);
		}

		// Return children of the current menu link
		return $ids;
	}





	/**
	 * Limit max menu depth in admin panel to
	 *
	 * @param      string  $hook   The current hook
	 */
	public static function limitMenuDepth( $hook = null ) {

		// If we're in the nav-menus hook
		if ( $hook === 'nav-menus.php' ) {

			// Override default value right after 'nav-menu' JS
			wp_add_inline_script(
				'nav-menu',
				'wpNavMenu.options.globalMaxDepth = ' . static::SETTING__MAX_MENU_DEPTH,
				'after'
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
		Utility\Utility::preventClassOverload();
	}
}
