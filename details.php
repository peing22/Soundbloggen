<?php
/* Av Petra Ingemarsson */

include("includes/config.php");
$page_title = "Blogginlägg";
include("includes/header.php");

// Kontroll om id finns i adressfältet
if (isset($_GET['id'])) {

    // Konverterar till heltal och lagrar id i en variabel
    $id = intval($_GET['id']);

    // Skapar instans av klass
    $post = new Blogpost();

    // Skapar variabel som lagrar returnerad array för specifikt blogginlägg
    $details = $post->getPostById($id);
} else {
    // Om id inte är medskickat skickas användaren tillbaka
    header('Location: posts.php');
}
?>

                <h2>Blogginlägg</h2>
                <p class="fivehundred">På denna sida visas inlägget i sin helhet.</p>
                <section  class="posts">
                    <h3><?= htmlspecialchars($details['title']); ?></h3>
                    <p class="light"><em>Postat <?= $details['created']; ?> av <a class="light" href="userposts.php?user=<?= $details['user']; ?>"><?= htmlspecialchars($details['firstname']) . " " . htmlspecialchars($details['lastname']); ?></a></em></p>
                    <?= $details['content']; ?>
                    
                </section>
                <p><button class="returnBtn">Tillbaka</button></p>
<?php
include("includes/footer.php");
?>