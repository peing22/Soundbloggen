<?php
/* Av Petra Ingemarsson */

include("includes/config.php");

// Skapar instans av klass
$user = new Bloguser();

// Om metoden som kontrollerar att användaren är inloggad returnerar false
if (!$user->loggedIn()) {

    // Skickar vidare till att logga in
    header("Location: login.php?error=1");
}

// Sätter standardvärde för att variabel för utskrift av meddelande inte ska ge felmeddelande
$deleteUserMessage = "";

// Kontroll om deleteuser förekommer i adressfältet
if (isset($_GET['deleteuser'])) {

    // Lagrar data i variabel
    $username = $_GET['deleteuser'];

    // Om metoden deleteUser returnerar true
    if($user->deleteUser($username)) {

        // Lagrar meddelande i variabel för utskrift på annat ställe
        $deleteUserMessage = "<p class='greenfivehundred'>Användarkontot har raderats!</p>";
    } else {
        // Lagrar meddelande i variabel för utskrift på annat ställe
        $deleteUserMessage = "<p class='redfivehundred'>Administratörskontot kan inte raderas!</p>";
    }
}

$page_title = "Administrera";
include("includes/header.php");
?>

                <h2>Administrera</h2>
                <?php
                // Om sessionsvariabel existerar och användarnamnet är admin
                if (isset($_SESSION['loggedin556']) and $_SESSION['username556'] === "admin") {

                    // Skriver ut meddelande
                    echo "<p class='fivehundred'>Som administratör kan du ändra och radera webbplatsens samtliga inlägg.<br>Du kan även radera användarkonton längre ner på sidan.</p>";
                } else {
                    // Skickar vidare till att logga in
                    header("Location: login.php?error=1");
                }
                ?>
                <?= $deleteUserMessage ?>

                <br>
                <h2 class="minusBorder">Samtliga inlägg</h2>
                <?php
                // Skapar instans av klass
                $post = new Blogpost();

                // Sätter standardvärde för att variabel för utskrift av meddelande inte ska ge felmeddelanden om den är tom
                $deletePostMessage = "";

                // Kontroll om delete förekommer i adressfältet
                if (isset($_GET['delete'])) {

                    // Konverterar till heltal och lagrar i variabel
                    $id = intval($_GET['delete']);

                    // Om metoden deletePost returnerar true
                    if ($post->deletePost($id)) {

                        // Lagrar meddelande i variabel för utskrift på annat ställe
                        $deletePostMessage = "<p class='greenfivehundred'>Inlägget har raderats!</p>";
                    } else {
                        // Lagrar felmeddelande i variabel för utskrift på annat ställe
                        $deletePostMessage = "<p class='redfivehundred'>Fel vid radering av inlägg!</p>";
                    }
                }
                // Skriver ut meddelande vid radering av inlägg
                echo $deletePostMessage;

                // Om get-metod returnerar en array
                if ($post->getPosts()) {

                    // Skapar variabel som lagrar returnerad array med inlägg
                    $postsArr = $post->getPosts();

                    // Loopar igenom array och skriver ut till skärm
                    foreach ($postsArr as $post) {
                ?>

                <section class="posts">
                    <h3><?= htmlspecialchars($post['title']); ?></h3>
                    <p class="light"><em>Postat <?= $post['created']; ?> av <a class="light" href="userposts.php?user=<?= $post['user']; ?>"><?= htmlspecialchars($post['firstname']) . " " . htmlspecialchars($post['lastname']); ?></a></em></p>
                    <?= $post['content']; ?>
                    <p class="postLinks"><a class="changeBtn" href="edit.php?id=<?= $post['id']; ?>">Ändra</a> <a class="deleteBtn" href="admin.php?delete=<?= $post['id']; ?>">Radera</a></p>
                </section>
                    <?php
                    }
                }
                ?>

                <br>
                <h2 class="minusBorder">Radera användarkonton</h2>
                <p>Om du väljer att radera ett användarkonto kommer alla användaruppgifter och postade inlägg för det specifika kontot att raderas från webbplatsen och det är inte möjligt att återskapa dem.</p>
                <p>Klicka på det konto du vill radera och bekräfta att kontot ska raderas.</p>
                <?php
                // Skapar instans av klass
                $user = new Bloguser();

                // Skapar variabel som lagrar returnerad array med alla användare
                $usersArr = $user->getUsers();
                ?>

                <ul class="bullets">
                    <?php 
                    // Loopar igenom array och skriver ut till skärm
                    foreach ($usersArr as $user) {
                    ?>

                    <li><a class="deleteUsrFromAdmin" href="admin.php?deleteuser=<?= $user['username']; ?>"><?= htmlspecialchars($user['firstname']); ?> <?= htmlspecialchars($user['lastname']); ?></a></li>
                    <?php                                
                    }
                    ?>

                </ul>
                <br>

<?php
include("includes/footer.php");
?>