<?php

// Set namespace
Namespace Wisewebs\Settings;

// Import relevant namespaces
Use Wisewebs\Classes\Content;



/**
 * Register image sizes
 */
function imageSizes() {

	/*----------  Page background  ----------*/

	add_image_size(
		Content\PageBackground::IMAGE_SIZE_NAME,
		Content\PageBackground::IMAGE_SIZE_WIDTH,
		Content\PageBackground::IMAGE_SIZE_HEIGHT
	);



	/*----------  Slideshow  ----------*/

	// Slideshow images need to be large enough to fill a 1080p display at least
	add_image_size(
		Content\Slideshow::IMAGE_SIZE_NAME,
		Content\Slideshow::IMAGE_SIZE_WIDTH,
		Content\Slideshow::IMAGE_SIZE_HEIGHT
	);



	/*----------  Cards  ----------*/

	add_image_size(
		Content\Cards::IMAGE_SIZE_NAME,
		Content\Cards::IMAGE_SIZE_WIDTH,
		Content\Cards::IMAGE_SIZE_HEIGHT
	);



	/*----------  Welcome text  ----------*/

	add_image_size(
		Content\WelcomeText::IMAGE_SIZE_NAME,
		Content\WelcomeText::IMAGE_SIZE_WIDTH,
		Content\WelcomeText::IMAGE_SIZE_HEIGHT
	);



	/*----------  Logotype list  ----------*/

	add_image_size(
		Content\LogotypeList::IMAGE_SIZE_NAME,
		Content\LogotypeList::IMAGE_SIZE_WIDTH,
		Content\LogotypeList::IMAGE_SIZE_HEIGHT
	);



	/*----------  Header  ----------*/

	add_image_size(
		Content\Header::IMAGE_SIZE_MIN_NAME,
		Content\Header::IMAGE_SIZE_MIN_WIDTH,
		Content\Header::IMAGE_SIZE_MIN_HEIGHT
	);

	add_image_size(
		Content\Header::IMAGE_SIZE_MAX_NAME,
		Content\Header::IMAGE_SIZE_MAX_WIDTH,
		Content\Header::IMAGE_SIZE_MAX_HEIGHT
	);



	/*----------  Hero image  ----------*/

	add_image_size(
		Content\HeroImage::IMAGE_SIZE_NAME,
		Content\HeroImage::IMAGE_SIZE_WIDTH,
		Content\HeroImage::IMAGE_SIZE_HEIGHT
	);

	add_image_size(
		'full_hd',
		1920
	);
}

add_action( 'after_setup_theme', 'Wisewebs\\Settings\\imageSizes' );
