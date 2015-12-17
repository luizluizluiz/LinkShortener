<?php

class ikliController
{
 
    protected $pdo;
    protected $timestamp;
    protected static $urlExists = true;
    protected static $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->timestamp = $_SERVER["REQUEST_TIME"];
    }

    public function urlToShortCode($url) {

        // Check if Empty
        if (empty($url)) {
            throw new \Exception("No_URL");
        }

        // Check URL Format
        if ($this->validateUrlFormat($url) == false) {
            throw new \Exception("Invalid_URL");
        }

        // Check if the URL can be found
        if (self::$urlExists) {
            if (!$this->verifyUrlExists($url)) {
                throw new \Exception("NOTEXIST_URL");
            }
        }

        // Check if URL is already on DB
        $shortURL = $this->verifyUrlInDb($url);
        if ($shortURL == false) {
            // Generate Short Code
            $shortURL = $this->createShortCode($url);
            //$shortCode = "NAILED_IT";
        }


        return $shortURL;
    }

    protected function validateUrlFormat($url) {
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
    }

    protected function createShortCode($url) {
        $id = $this->insertInDb($url);
        $shortURL = $this->convertIdToCode($id);    
        $this->updateInDb($id, $shortURL);
        return $shortURL;
    }
    
    protected function convertIdToCode($id) {
        $id = intval($id);
        if ($id < 1) {
            throw new \Exception(
                "NOTVALID_ID" . $id);
        }
        $keys = strlen(self::$chars);
        $code = "";
        while ($id > $keys - 1) {
            // determine the value of the next higher character
            // in the short code should be and prepend
            $code = self::$chars[fmod($id, $keys)] . $code;
            // reset $id to remaining value to be converted
            $id = floor($id / $keys);
        }

        // remaining value of $id is less than the length of
        // self::$chars
        $code = self::$chars[$id] . $code;

        return $code;
    }

    protected function updateInDb($id, $shortURL) {
        if ($id == null || $shortURL == null) {
            throw new \Exception("Input parameter(s) invalid.");
        }
        $query = "UPDATE " . URL_TABLE .
            " SET SHORT_URL = :short_code WHERE UID = :id";
        $stmnt = $this->pdo->prepare($query);
        $params = array(
            "short_code" => $shortURL,
            "id" => $id
        );
        $stmnt->execute($params);

        if ($stmnt->rowCount() < 1) {
            throw new \Exception(
                "Row was not updated with shortURL.");
        }

        return true;
    }

    protected function insertInDb($url) {
       $query = "INSERT INTO " . URL_TABLE .
            " (LONG_URL, DATE_CREATED) " .
            " VALUES (:long_url, :timestamp)";
        $stmnt = $this->pdo->prepare($query);
        $params = array(
            "long_url" => $url,
            "timestamp" => $this->timestamp
        );
        $stmnt->execute($params); 
        return $this->pdo->lastInsertId();
        //return $query;
    }

    /* Check to see if the URL exists (cURL) */
    protected function verifyUrlExists($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return (!empty($response) && $response != 404);
    }

    protected function verifyUrlInDb($url) {
        $query = "SELECT SHORT_URL FROM " . URL_TABLE .
            " WHERE LONG_URL = :long_url LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "long_url" => $url
        );
        $stmt->execute($params);
        $result = $stmt->fetch();
        return (empty($result)) ? false : $result["SHORT_URL"];
    }
}
