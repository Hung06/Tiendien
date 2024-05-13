<?php
session_start();
$_SESSION["IsLogin"] = false;



$fields = parse_url($uri);

// Build the DSN including SSL settings
$conn = "mysql:";
$conn .= "host=" . $fields["host"];
$conn .= ";port=" . $fields["port"];
$conn .= ";dbname=" . ltrim($fields["path"], '/');
$conn .= ";sslmode=verify-ca;sslrootcert=ca.pem";

try {
    $db = new PDO($conn, $fields["user"], $fields["pass"]);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
