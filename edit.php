<?php
/* Av Petra Ingemarsson */

include("includes/config.php");
$page_title = "Ändra inlägg";
include("includes/header.php");
?>

                <h2>Ändra inlägg</h2>
<?php
// Skapar instans av klass
$post = new Blogpost();

// Sätter standardvärde för att variabler för utskrift av meddelanden inte ska ge felmeddelanden
$setTitleMessage = "";
$setContentMessage = "";
$updatePostMessage = "";

// Kontroll om sessionsvariabel exixterar (inloggad)
if (isset($_SESSION['username556'])) {

    // Kontrollerar om id finns i adressfältet
    if (isset($_GET['id'])) {

        // Konverterar till heltal och lagrar id i en variabel
        $id = intval($_GET['id']);

        // Skapar variabel som lagrar returnerad array för specifikt inlägg
        $details = $post->getPostById($id);

        // Villkor för att kunna ändra ett inlägg
        if ($details['user'] === $_SESSION['username556'] or $_SESSION['username556'] === "admin") {

            // Kontroll att formulärdata är angivet
            if (isset($_POST['title'])) {

                // Lagrar formulärdata i variabler
                $title = $_POST['title'];
                $content = $_POST['content'];

                // Variabel som lagrar om angiven formulärdata passerar kontroller eller inte
                $success = true;

                // Om metoden setTitle returnerar false pga felaktig titel
                if (!$post->setTitle($title)) {

                    // Ändrar variabel till false
                    $success = false;

                    // Lagrar felmeddelande i variabel
                    $setTitleMessage = "<p class='redfivehundred'>Titel måste anges!</p>";
                }

                // Om metoden setContent returnerar false pga felaktigt innehåll
                if (!$post->setContent($content)) {

                    // Ändrar variabel till false
                    $success = false;

                    // Lagrar felmeddelande i variabel
                    $setContentMessage = "<p class='redfivehundred'>Innehåll måste anges!</p>";
                }

                // Om angiven formulärdata är korrekt
                if ($success) {

                    // Kontroll om updatePost-metod returnerar true vid medskickat data
                    if ($post->updatePost($id)) {

                        // Skickar vidare till bekräftelsesida
                        header('Location: editconfirm.php');

                    } else {
                        // Lagrar felmeddelande i variabel för utskrift på annat ställe
                        $updatePostMessage = "<p class='redfivehundred'>Fel vid ändring av inlägg!</p>";
                    }
                } else {
                    // Lagrar felmeddelande i variabel för utskrift på annat ställe
                    $updatePostMessage = "<p class='redfivehundred'>Ändringar har inte sparats! Kontrollera värden och försök igen.</p>";
                }
            }
            ?>

                    <section>
                        <?= $updatePostMessage ?>

                        <h3><?= htmlspecialchars($details['title']); ?></h3>
                        <form action="edit.php?id=<?= $id; ?>" method="post">
                            <div class="container">
                                <?= $setTitleMessage ?>

                                <div class="item">
                                    <label for="title">Titel:</label>
                                    <br>
                                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($details['title']); ?>">
                                    <br>
                                </div>
                                <?= $setContentMessage ?>

                                <div class="item">
                                    <label for="content">Innehåll:</label>
                                    <br>
                                    <textarea name="content" id="content"><?= htmlspecialchars($details['content']); ?></textarea>
                                    <br>
                                </div>
                            </div>
                            <input type="submit" value="Ändra inlägg">
                        </form>
                    </section>

                    <script>
                        ClassicEditor
                            .create( document.querySelector( '#content' ) )
                            .catch( error => {
                                console.error( error );
                            } );
                    </script>
            <?php
        // Om behörighet saknas att ändra inlägg
        } else {
                    echo '<p class="redfivehundred">Du saknar behörighet att ändra detta inlägg!</p>';
        }
    // Om id saknas i adressfältet
    } else {
                    echo '<p class="fivehundred">Du måste välja vilket inlägg du vill ändra...</p>';
    }
// Om sessionsvariabel inte existerar (ej inloggad)
} else {
    header('Location: index.php');
}
include("includes/footer.php");
?>