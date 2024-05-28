<?php
/* Av Petra Ingemarsson */

// Aktiverar session
session_start();

// Raderar sessionsvariabler
session_unset();

// Förstör hela sessionen
session_destroy();

// Skickar tillbaka till startsidan
header('Location: index.php');

// Slutar köra PHP-koden
exit();
?>