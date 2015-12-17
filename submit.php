<?php
require_once "conf/props.php";
require_once "conf/ikliController.php";
error_reporting(0); // turn off notice in casting indexes when creating short URLs.
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: error.php?code=InvalidMethod");
    exit;
} 

try {
    $pdo = new PDO(DB_PDODRIVER . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
}
catch (\PDOException $e) {
    //header("Location: result.html?code=" . $e);
    echo $e;
    exit;
}

$ikliController = new ikliController($pdo);
try {
    $code = $ikliController->urlToShortCode($_POST["url"]);

    $url = SHORTURL_PREFIX . $code;
    if (!empty($url)) {
            // validate
            session_start();
            $_SESSION['longURL'] = $_POST["url"];
            $_SESSION['shortenedURL'] = $url;
            header("Location: index.php");
    }
}
catch (\Exception $e) {
    header("Location: error.php?errorCode=" . htmlentities($e->getMessage()));
    exit;
}
