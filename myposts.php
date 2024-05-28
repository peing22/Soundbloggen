<?php
/* Av Petra Ingemarsson */

include("includes/config.php");

// Skapar instans av klass
$user = new Bloguser();

// Om metoden som kontrollerar att användaren är inloggad returnerar false
if (!$user->loggedIn()) {

    // Skickar vidare till att logga in
    header("Location: loginuser.php?error=1");
}

// Kontroll om deleteuser förekommer i adressfältet
if (isset($_GET['deleteuser'])) {

    // Lagrar sessionsdata i variabel
    $username = $_SESSION['username556'];

    // Om metoden deleteUser returnerar true
    if($user->deleteUser($username)) {

        // Raderar sessionsvariabler
        session_unset();

        // Förstör hela sessionen
        session_destroy();

        // Skickar vidare till startsidan
        header("Location: index.php");
    }
}

$page_title = "Mina inlägg";
include("includes/header.php");
?>

                <h2>Mitt konto</h2>
                <?php
                // Om sessionsvariabel existerar
                if (isset($_SESSION['loggedin556'])) {

                    // Skriver ut meddelande
                    echo $_SESSION['loggedin556'];
                }
                ?>

                <section>
                    <h2 class="minusBorder">Skapa nytt inlägg</h2>
                    <?php
                    // Skapar instans av klass
                    $post = new Blogpost();

                    // Sätter standardvärden för att formuläret inte ska ge felmeddelanden innan angiven formulärdata
                    $title = "";
                    $content = "";

                    // Sätter standardvärde för att variabler för utskrift av meddelanden inte ska ge felmeddelanden
                    $setTitleMessage = "";
                    $setContentMessage = "";
                    $addPostMessage = "";
                    $deletePostMessage = "";

                    // Kontroll om delete förekommer i adressfältet
                    if (isset($_GET['delete'])) {

                        // Konverterar till heltal och lagrar i variabel
                        $id = intval($_GET['delete']);

                        // Skapar variabel som lagrar returnerad array för specifikt inlägg
                        $details = $post->getPostById($id);

                        // Villkor för att kunna radera ett inlägg
                        if ($details['user'] === $_SESSION['username556'] or $_SESSION['username556'] === "admin") {

                            // Om metoden deletePost returnerar true
                            if ($post->deletePost($id)) {

                                // Lagrar meddelande i variabel för utskrift på annat ställe
                                $deletePostMessage = "<p class='greenfivehundred'>Ditt inlägg har raderats!</p>";
                            } else {
                                // Lagrar felmeddelande i variabel för utskrift på annat ställe
                                $deletePostMessage = "<p class='redfivehundred'>Fel vid radering av inlägg!</p>";
                            }
                        } else {
                            // Lagrar felmeddelande i variabel för utskrift på annat ställe
                            $deletePostMessage = "<p class='redfivehundred'>Du saknar behörighet att radera inlägget!</p>";
                        }
                    }

                    // Kontroll att formulärdata är angivet
                    if (isset($_POST['title'])) {

                        // Lagrar formulärdata i variabler
                        $title = $_POST['title'];
                        $content = $_POST['content'];

                        // Lagrar sessionsdata i en variabel
                        $username = $_SESSION['username556'];

                        // Variabel som anger om angiven formulärdata passerar kontroller eller inte
                        $success = true;

                        // Om metoden setTitle returnerar false pga felaktig titel
                        if (!$post->setTitle($title)) {

                            // Ändrar variabel till false
                            $success = false;

                            // Lagrar felmeddelande i variabel för utskrift på annat ställe
                            $setTitleMessage = "<p class='redfivehundred'>Titel måste anges!</p>";
                        }

                        // Om metoden setContent returnerar false pga felaktigt innehåll
                        if (!$post->setContent($content)) {

                            // Ändrar variabel till false
                            $success = false;

                            // Lagrar felmeddelande i variabel för utskrift på annat ställe
                            $setContentMessage = "<p class='redfivehundred'>Innehåll måste anges!</p>";
                        }

                        // Om metoden setUser returnerar false
                        if (!$post->setUser($username)) {

                            // Ändrar variabel till false
                            $success = false;
                        }

                        // Om angiven formulärdata är korrekt
                        if ($success) {

                            // Kontroll om addPost-metod returnerar true
                            if ($post->addPost()) {

                                // Lagrar meddelande i variabel för utskrift på annat ställe
                                $addPostMessage = "<p class='greenfivehundred'>Ditt inlägg har publicerats!</p>";

                                // Återställer standardvärden i formuläret
                                $title = "";
                                $content = "";
                            } else {
                                // Lagrar felmeddelande i variabel för utskrift på annat ställe
                                $addPostMessage = "<p class='redfivehundred'>Fel vid publicering av inlägg!</p>";
                            }
                        } else {
                            // Lagrar felmeddelande i variabel för utskrift på annat ställe
                            $addPostMessage = "<p class='redfivehundred'>Ditt inlägg har inte publicerats! Kontrollera värden och försök igen.</p>";
                        }
                    }
                    ?>
                    <?= $addPostMessage ?>

                    <form action="myposts.php" method="post">
                        <div class="container">
                            <?= $setTitleMessage ?>
                        
                            <div class="item">
                                <label for="title">Titel:</label>
                                <br>
                                <input type="text" id="title" name="title" title="Titel måste anges (max 128 tecken)" value="<?= htmlspecialchars($title); ?>">
                                <br>
                            </div>
                            <?= $setContentMessage ?>

                            <div class="item">
                                <label for="content">Innehåll:</label>
                                <br>
                                <textarea name="content" id="content"><?= htmlspecialchars($content); ?></textarea>
                                <br>
                            </div>
                        </div>
                        <p>När du publicerar ett inlägg kommer det visas för alla som besöker webbplatsen. Inlägget kommer visas i sin helhet tillsammans med datum och tid för när inlägget publicerades samt med det förnamn och efternamn som är registrerat för ditt användarkonto.</p>
                        <input type="submit" value="Publicera">
                    </form>
                </section>
                <section>
                    <h2 class="minusBorder">Mina inlägg</h2>
                    <?= $deletePostMessage ?>

                    <?php
                    // Lagrar sessionsdata i variabel
                    $user = $_SESSION['username556'];

                    // Kontroll om getPostsByUser-metod returnerar en array
                    if ($post->getPostsByUser($user)) {

                        // Skapar variabel som lagrar returnerad array med inlägg för specifik användare
                        $postsArr = $post->getPostsByUser($user);

                        // Loopar igenom array och skriver ut till skärm
                        foreach ($postsArr as $post) {
                        ?>

                        <section class="posts">
                            <h3><?= htmlspecialchars($post['title']); ?></h3>
                            <p class="light"><em>Postat <?= $post['created']; ?> av <?= htmlspecialchars($post['firstname']) . " " . htmlspecialchars($post['lastname']); ?></em></p>
                            <?= $post['content']; ?>
                            <p class="postLinks"><a class="changeBtn" href="edit.php?id=<?= $post['id']; ?>">Ändra</a> <a class="deleteBtn" href="myposts.php?delete=<?= $post['id']; ?>">Radera</a></p>
                        </section>
                        <?php
                        }
                        ?>

                        <?php
                    // Skriver ut meddelande om metoden inte returnerar en array
                    } else {
                        echo "<p>Du har inte publicerat några inlägg än...</p>";
                    }
                    ?>

                </section>
                <?php
                // Kontroll att användarnamnet inte är admin
                if (!($_SESSION['username556'] === "admin")) {
                ?>
                <section>
                <h2 class="minusBorder">Radera konto</h2>
                <p>Om du väljer att radera ditt användarkonto kommer alla dina användaruppgifter och postade inlägg att raderas från webbplatsen och det är inte möjligt att återskapa dem. Om du ångrar dig måste du därför skapa ett nytt konto och publicera nya inlägg. Vill du radera ditt konto? <a id="deleteUsr" href="myposts.php?deleteuser">Ja, radera mitt konto</a>.</p>
                </section>
                <?php 
                }
                ?>

                    <script>
                        ClassicEditor
                            .create( document.querySelector( '#content' ) )
                            .catch( error => {
                                console.error( error );
                            } );
                    </script>
<?php
include("includes/footer.php");
?>