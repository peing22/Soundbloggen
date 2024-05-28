<?php
/* Av Petra Ingemarsson */

include("includes/config.php");
$page_title = "Blogginlägg";
include("includes/header.php");
?>

                <h2>Blogginlägg</h2>
                <p class="fivehundred">På denna sida visas samtliga inlägg publicerade av registrerade användare.</p>
                <?php
                // Skapar instans av klass
                $post = new Blogpost();

                // Skapar variabel som lagrar returnerad array med alla inlägg
                $postsArr = $post->getPosts();

                // Kontroll om arrayen innehåller inlägg
                if (count($postsArr) > 0) {

                    // Loopar igenom array och skriver ut till skärm
                    foreach ($postsArr as $post) {
                    ?>
    
                    <section class="posts">
                        <h3><?= htmlspecialchars($post['title']); ?></h3>
                        <p class="light"><em>Postat <?= $post['created']; ?> av <a class="light" href="userposts.php?user=<?= $post['user']; ?>"><?= htmlspecialchars($post['firstname']) . " " . htmlspecialchars($post['lastname']); ?></a></em></p>                            
                            <?php
                            // Om innehåll är längre än 500 tecken
                            if (mb_strlen($post['content']) > 500) {

                                // Begränsar strängen till 500 tecken
                                $cutString = substr($post['content'], 0, 500);
                    
                                // Kapar strängen mellan två ord
                                $newString = substr($cutString, 0, strrpos($cutString, ' '));
                    
                                // Skriver ut innehåll till skärm tillsammans med en länk för att läsa mer
                                echo strip_tags($newString, '<p>') . '...<p class="postLinks"><a class="changeBtn" href="details.php?id=' . $post['id'] . '"> Läs mer</a></p>';
                            } else {
                                // Om innehåll inte är längre än 500 tecken skrivs innehåll ut med länk utan att kapa strängen
                                echo $post['content'] . '<p class="postLinks"><a class="changeBtn" href="details.php?id=' . $post['id'] . '"> Läs mer</a></p>';
                            }
                            ?>
    
                    </section>
                    <?php
                    }
                // Skriver ut meddelande
                } else {
                    echo '<p class="fivehundred">Det har inte publicerats några inlägg än...</p>';
                }
                ?>

                    <br>
<?php
include("includes/footer.php");
?>