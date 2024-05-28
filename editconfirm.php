<?php
/* Av Petra Ingemarsson */

include("includes/config.php");
$page_title = "Ändra inlägg";
include("includes/header.php");

// Kontroll om sessionsvariabel exixterar (inloggad)
if (isset($_SESSION['username556'])) {
?>

                <h2>Ändra inlägg</h2>
                <p class='greenfivehundred'>Ändringarna har sparats!</p>
<?php
} else {
    header('Location: index.php');
}
include("includes/footer.php");
?>