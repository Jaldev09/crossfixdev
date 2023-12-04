<?php
use Wisewebs\Classes\Content;

Content\LogotypeList::output(
	get_field(
		Content\LogotypeList::FIELD_NAME,
		'option'
	)
);
