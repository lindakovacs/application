<?php

/**
 * Test: Nette\Application\Routers\Route with Modules
 */

use Nette\Application\Routers\Route;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';

require __DIR__ . '/Route.php';


$route = new Route('<presenter>', array(
	'module' => 'Module:Submodule',
));

testRouteIn($route, '/abc', 'Module:Submodule:Abc', array(
	'test' => 'testvalue',
), '/abc?test=testvalue');

testRouteIn($route, '/');
Assert::null(testRouteOut($route, 'Homepage'));
Assert::null(testRouteOut($route, 'Module:Homepage'));
Assert::same('http://example.com/homepage', testRouteOut($route, 'Module:Submodule:Homepage'));


$route = new Route('<presenter>', array(
	'module' => 'Module:Submodule',
	'presenter' => 'Default',
));

testRouteIn($route, '/', 'Module:Submodule:Default', array(
	'test' => 'testvalue',
), '/?test=testvalue');

Assert::null(testRouteOut($route, 'Homepage'));
Assert::null(testRouteOut($route, 'Module:Homepage'));
Assert::same('http://example.com/homepage', testRouteOut($route, 'Module:Submodule:Homepage'));


$route = new Route('<module>/<presenter>', array(
	'presenter' => 'AnyDefault',
));

testRouteIn($route, '/module.submodule', 'Module:Submodule:AnyDefault', array(
	'test' => 'testvalue',
), '/module.submodule/?test=testvalue');

Assert::null(testRouteOut($route, 'Homepage'));
Assert::same('http://example.com/module/homepage', testRouteOut($route, 'Module:Homepage'));
Assert::same('http://example.com/module.submodule/homepage', testRouteOut($route, 'Module:Submodule:Homepage'));


$route = new Route('<module>/<presenter>', array(
	'module' => 'Module:Submodule',
	'presenter' => 'Default',
));

testRouteIn($route, '/module.submodule', 'Module:Submodule:Default', array(
	'test' => 'testvalue',
), '/?test=testvalue');

Assert::null(testRouteOut($route, 'Homepage'));
Assert::same('http://example.com/module/homepage', testRouteOut($route, 'Module:Homepage'));
Assert::same('http://example.com/module.submodule/homepage', testRouteOut($route, 'Module:Submodule:Homepage'));


$route = new Route('[<module>/]<presenter>');
testRouteIn($route, '/home', 'Home', array(
	'test' => 'testvalue',
), '/home?test=testvalue');


$route = new Route('[<module=Def>/]<presenter>');
testRouteIn($route, '/home', 'Def:Home', array(
	'test' => 'testvalue',
), '/home?test=testvalue');


$route = new Route('[<module>/]<presenter>');
testRouteIn($route, '/module/home', 'Module:Home', array(
	'test' => 'testvalue',
), '/module/home?test=testvalue');


$route = new Route('[<module=def>/]<presenter>');
testRouteIn($route, '/module/home', 'Module:Home', array(
	'test' => 'testvalue',
), '/module/home?test=testvalue');


$route = new Route('[<module>/]<presenter>');
testRouteIn($route, '/module.submodule/home', 'Module:Submodule:Home', array(
	'test' => 'testvalue',
), '/module.submodule/home?test=testvalue');


$route = new Route('[<module>/]<presenter>');
testRouteIn($route, '/module/submodule.home', 'Module:Submodule:Home', array(
	'test' => 'testvalue',
), '/module.submodule/home?test=testvalue');