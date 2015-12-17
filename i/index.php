<?php
require_once "conf/props.php";
require_once "conf/ikliController.php";


if (empty($_GET["k"])) {
    echo "Nothing to do here. Just move along";
    exit;
} 
$code = $_GET["k"];
try {
    $pdo = new PDO(DB_PDODRIVER . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE,
        DB_USERNAME, DB_PASSWORD);
}
catch (\PDOException $e) {
    header("Location: error.html");
    exit;
}

$ikliController = new ikliController($pdo);
try {
    $url = $ikliController->resolveShortCode($code);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $url);
}
catch (\Exception $e) {
print_r($e);
    header("Location: error.html");
    exit;
}
?>