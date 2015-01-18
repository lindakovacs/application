<?php

/**
 * Test: Nette\Application\Request
 */

use Nette\Application\Request,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


test(function() {
	$request = new Request('Homepage', 'GET', array('a' => 1, 'b' => NULL));

	Assert::same( 1, $request->getParameter('a') );
	Assert::same( NULL, $request->getParameter('b') );
});


test(function() {
	$request = new Request('Homepage', 'GET', array(), array('a' => 1, 'b' => NULL));

	Assert::same( array('a' => 1, 'b' => NULL), $request->getPost() );
	Assert::same( 1, $request->getPost('a') );
	Assert::same( NULL, $request->getPost('b') );
});
