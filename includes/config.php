<?php
/* Av Petra Ingemarsson */

$site_title = "Sound";
$divider = " | ";

// Inkluderar klassfil(er) i övriga PHP-filer
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php';
});

// Utvecklarläge eller inte
$devmode = true;

// Om utvecklarläge
if ($devmode) {

    // Aktiverar felrapportering
    error_reporting(-1);
    ini_set("display_errors", 1);

    // Lokala databasinställningar för anslutning till databas
    define("DBHOST", "localhost");
    define("DBUSER", "root");
    define("DBPASS", "");
    define("DBDATABASE", "Sound");

} else {
    // Databasinställningar för anslutning till databas externt (ändra "#" till rätt uppgifter)
    define("DBHOST", "#");
    define("DBUSER", "#");
    define("DBPASS", "#");
    define("DBDATABASE", "#");
}

// Aktiverar session
session_start();
?>