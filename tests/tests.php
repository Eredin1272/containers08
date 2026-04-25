<?php

require_once __DIR__ . '/testframework.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../modules/database.php';
require_once __DIR__ . '/../modules/page.php';

$testFramework = new TestFramework();

function testDbConnection() {
    global $config;
    $db = new Database($config["db"]["path"]);
    return assertExpression($db != null, "DB connected", "DB failed");
}

function testDbCount() {
    global $config;
    $db = new Database($config["db"]["path"]);
    return assertExpression($db->Count("page") >= 3);
}

function testDbCreate() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $id = $db->Create("page", ["title" => "Test", "content" => "Test"]);
    return assertExpression($id > 0);
}

function testDbRead() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $data = $db->Read("page", 1);
    return assertExpression($data != null);
}

function testPageRender() {
    $page = new Page(__DIR__ . '/../templates/index.tpl');
    $html = $page->Render(["title" => "Test", "content" => "Hello"]);
    return assertExpression(strpos($html, "Test") !== false);
}

$testFramework->add('DB connection', 'testDbConnection');
$testFramework->add('DB count', 'testDbCount');
$testFramework->add('DB create', 'testDbCreate');
$testFramework->add('DB read', 'testDbRead');
$testFramework->add('Page render', 'testPageRender');

$testFramework->run();

echo $testFramework->getResult();