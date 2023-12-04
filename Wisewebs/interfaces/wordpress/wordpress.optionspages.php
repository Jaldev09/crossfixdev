<?php
/**
 * Interface for classes interacting with WordPress' options pages.
 */


// Set the namespace
Namespace Wisewebs\Interfaces\WordPress;


Interface OptionsPages extends WordPress {

	public static function registerOptionsPage();

	public static function addPluginPage();

	public static function createAdminPage();
}
