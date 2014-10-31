<?php

return [
	[
		'get',
		'post/{title}/',
		'OriginalAppName\Site\Elttl\Controller\Content::single'
	],
	[
		'get',
		'result/',
		'OriginalAppName\Site\Elttl\Controller\Result::index'
	],
	[
		'get',
		'result/{year:number}/',
		'OriginalAppName\Site\Elttl\Controller\Result::year'
	]
];
