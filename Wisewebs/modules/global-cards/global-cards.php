<?php
use Wisewebs\Classes\Content;

Content\Cards::output(
	get_field(
		Content\Cards::FIELD_NAME,
		'option'
	)
);
