<?php
/* Av Petra Ingemarsson */

include("includes/config.php");
$page_title = "Startsida";
include("includes/header.php");
?>

                <h2>Startsida</h2>
                <p class="fivehundred">Välkommen till orkestergruppen Sounds officiella bloggportal. Här kan både orkestermedlemmar och fans skapa användarkonton för att blogga om allt mellan himmel och jord, men kanske helst om sådant som rör den fantastiska orkestergruppen och deras musik! Tänk på att hålla en trevlig ton i dina inlägg. Olämpligt formulerade blogginlägg kommer ändras eller raderas av administratören.</p><br>
                <?php
                // Skapar instans av klass
                $user = new Bloguser();

                // Skapar variabel som lagrar returnerad array med alla användare
                $usersArr = $user->getUsers();
                ?>

                <p class="fivehundred">Användare:</p>
                <ul class="bullets">
                    <?php 
                    // Loopar igenom array och skriver ut till skärm
                    foreach ($usersArr as $user) {
                    ?>

                    <li><a class="light" href="userposts.php?user=<?= $user['username']; ?>"><?= htmlspecialchars($user['firstname']) . " " . htmlspecialchars($user['lastname']); ?></a></li>
                    <?php                                
                    }
                    ?>

                </ul>
                <br>
                <h2 class="minusBorder">Senaste inläggen</h2>
                <?php
                // Skapar instans av klass
                $post = new Blogpost();

                // Skapar variabel som lagrar returnerad array med alla inlägg
                $postsArr = $post->getPosts();

                // Om arrayen innehåller minst fem inlägg
                if (count($postsArr) > 4) {

                    // Loopar igenom array och skriver ut till skärm
                    for ($i = 0; $i < 5; $i++) {
                    ?>

                    <section class="posts">
                        <h3><?= htmlspecialchars($postsArr[$i]['title']); ?></h3>
                        <p class="light"><em>Postat <?= $postsArr[$i]['created']; ?> av <a class="light" href="userposts.php?user=<?= $postsArr[$i]['user']; ?>"><?= htmlspecialchars($postsArr[$i]['firstname']) . " " . htmlspecialchars($postsArr[$i]['lastname']); ?></a></em></p>                      
                        <?php
                        // Om innehåll är längre än 500 tecken
                        if (mb_strlen($postsArr[$i]['content']) > 500) {

                            // Begränsar strängen till 500 tecken
                            $cutString = substr($postsArr[$i]['content'], 0, 500);
                
                            // Kapar strängen mellan två ord
                            $newString = substr($cutString, 0, strrpos($cutString, ' '));
                
                            // Skriver ut innehåll till skärm tillsammans med en länk för att läsa mer
                            echo strip_tags($newString, '<p>') . '...<p class="postLinks"><a class="changeBtn" href="details.php?id=' . $postsArr[$i]['id'] . '"> Läs mer</a></p>';
                        } else {
                            // Om innehåll inte är längre än 500 tecken skrivs innehåll ut med länk utan att kapa strängen
                            echo $postsArr[$i]['content'] . '<p class="postLinks"><a class="changeBtn" href="details.php?id=' . $postsArr[$i]['id'] . '"> Läs mer</a></p>';
                        }
                        ?>

                    </section>
                    <?php
                    }
                // Om arrayen innehåller färre än fem inlägg men minst ett inlägg
                } elseif (count($postsArr) < 5 and count($postsArr) > 0) {

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
                // Om arrayen är tom
                } else {
                    echo '<p class="fivehundred">Det har inte publicerats några inlägg än...</p>';
                }
                ?>

                <br>
<?php
include("includes/footer.php");
?>