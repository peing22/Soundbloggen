<?php
/* Av Petra Ingemarsson */

include("includes/config.php");
$page_title = "Blogginlägg";
include("includes/header.php");

            // Kontroll om user förekommer i adressfältet
            if (isset($_GET['user'])) {

                // Lagrar i variabel
                $user = $_GET['user'];
                ?>

                <h2>Blogginlägg</h2>
                <?php
                // Skapar instans av klass
                $author = new Bloguser();

                // Skapar variabel som lagrar författare
                $author = $author->getAuthor($user);

                // Skriver ut vems blogginlägg som visas på sidan
                echo '<p class="fivehundred">På denna sida visas samtliga inlägg publicerade av ' . htmlspecialchars($author) . '.</p>';

                // Skapar instans av klass
                $post = new Blogpost();

                // Skapar variabel som lagrar returnerad array med inlägg för specifik användare
                $postsArr = $post->getPostsByUser($user);

                // Kontroll om arrayen innehåller inlägg
                if (count($postsArr) > 0) {

                    // Loopar igenom array och skriver ut till skärm
                    foreach ($postsArr as $post) {
                    ?>

                    <section class="posts">
                        <h3><?= htmlspecialchars($post['title']); ?></h3>
                        <p class="light"><em>Postat <?= $post['created']; ?> av <?= htmlspecialchars($post['firstname']) . " " . htmlspecialchars($post['lastname']); ?></em></p>
                        <?= $post['content']; ?>
                        
                    </section>
                    <?php
                    }
                // Om arrayen är tom
                } else {
                    // Skriver ut meddelande
                    echo '<p>' . htmlspecialchars($author) . ' har inte publicerat några inlägg än...</p>';
                }
            } else {
                // Om user inte är medskickat skickas användaren tillbaka
                header('Location: index.php');
            }
            ?>

                <p><button class="returnBtn">Tillbaka</button></p>
<?php
include("includes/footer.php");
?>