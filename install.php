<?php
/* Av Petra Ingemarsson */

include("includes/config.php");

// Om utvecklarläge
if ($devmode) {

    // Ansluter till databas
    $db = new mysqli("localhost", "root", "", "mysql");

    // Kontroll om fel vid anslutning
    if ($db->connect_errno > 0) {

        // Skriver ut felmeddelande
        die("Fel vid anslutning: " . $db->connect_error);
    }

    // Skapar databas och användare om databasen inte redan finns
    $sql = "CREATE DATABASE IF NOT EXISTS Sound;
    CREATE USER IF NOT EXISTS '" . DBUSER . "'@'" . DBHOST . "' IDENTIFIED BY '" . DBPASS . "';
    GRANT ALL PRIVILEGES ON " . DBDATABASE . ".* TO '" . DBUSER . "'@'" . DBHOST . "';";

    // Skriver ut SQL-frågor till skärmen
    echo "<pre>$sql</pre>";

    // Skickar SQL-frågor till servern
    if ($db->multi_query($sql)) {
        echo "Databas och användare installerad!";
    } else {
        echo "Fel vid installation av databas!";
    }
    // Stänger anslutning
    $db->close();
}

// Ansluter till databasen
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

// Kontroll om fel vid anslutning
if ($db->connect_errno > 0) {

    // Skriver ut felmeddelande
    die("Fel vid anslutning: " . $db->connect_error);
}

// Tar bort tabellerna om de existerar
$sql = "DROP TABLE IF EXISTS blogposts, blogusers;";

// Skapar tabellen users
$sql .= "CREATE TABLE blogusers(
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL PRIMARY KEY,
    password VARCHAR(256) NOT NULL
);";

// Skapar tabellen blogposts
$sql .= "CREATE TABLE blogposts(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(128) NOT NULL,
    content TEXT NOT NULL,
    created TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    user VARCHAR(30) NOT NULL
);";

// Hashar administratörslösenord
$hashedPassword = password_hash('cykelställ159', PASSWORD_DEFAULT);

// SQL-fråga för att skapa administratörskonto
$sql .= "INSERT INTO blogusers(firstname, lastname, username, password) VALUES('Petra', 'Ingemarsson (admin)', 'admin', '$hashedPassword');";

// Skriver ut SQL-frågor till skärmen
echo "<pre>$sql</pre>";

// Skickar SQL-frågor till servern
if ($db->multi_query($sql)) {
    echo "Installation av tabeller och insättning av admin har lyckats!";
} else {
    echo "Fel vid installation av tabeller och insättning av admin!";
}
?>