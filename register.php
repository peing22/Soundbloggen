<?php
/* Av Petra Ingemarsson */

include("includes/config.php");
$page_title = "Skapa konto";
include("includes/header.php");

// Sätter standardvärden för att formuläret inte ska ge felmeddelanden innan angiven formulärdata
$firstname = "";
$lastname = "";
$username = "";

// Sätter standardvärde för att variabler för utskrift av meddelanden inte ska ge felmeddelanden
$setFirstnameMessage = "";
$setLastnameMessage = "";
$setUsernameMessage = "";
$setPasswordMessage = "";
$usernameTaken = "";
$passwordsDoesNotMatchMessage = "";
$registerUserMessage = "";

// Kontroll att formulärdata är angivet
if (isset($_POST['username'])) {

    // Lagrar formulärdata i variabler
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $verifypassword = $_POST['verifypassword'];

    // Kontroll att inmatade lösenord stämmer överens
    if ($password == $verifypassword) {

        // Skapar instans av klass
        $user = new Bloguser();

        // Variabel som anger om angiven formulärdata passerar kontroller eller inte
        $success = true;

        // Om metoden setFirstname returnerar false pga felaktigt förnamn
        if (!$user->setFirstname($firstname)) {

            // Ändrar variabel till false
            $success = false;

            // Lagrar felmeddelande i variabel för utskrift på annat ställe
            $setFirstnameMessage = "<p class='redfivehundred'>Förnamn måste anges med minst två, max 30 bokstäver!</p>";
        }

        // Om metoden setLastname returnerar false pga felaktigt efternamn
        if (!$user->setLastname($lastname)) {

            // Ändrar variabel till false
            $success = false;

            // Lagrar felmeddelande i variabel för utskrift på annat ställe
            $setLastnameMessage = "<p class='redfivehundred'>Efternamn måste anges med minst två, max 30 bokstäver!</p>";
        }

        // Om metoden setUsername returnerar false pga felaktigt användarnamn
        if (!$user->setUsername($username)) {

            // Ändrar variabel till false
            $success = false;

            // Lagrar felmeddelande i variabel för utskrift på annat ställe
            $setUsernameMessage = "<p class='redfivehundred'>Användarnamn måste anges med minst fem, max 30 bokstäver och/eller siffror!</p>";
        }

        // Om metoden setPassword returnerar false pga felaktigt lösenord
        if (!$user->setPassword($password)) {

            // Ändrar variabel till false
            $success = false;

            // Lagrar felmeddelande i variabel för utskrift på annat ställe
            $setPasswordMessage = "<p class='redfivehundred'>Lösenord måste anges med minst åtta tecken!</p>";
        }

        // Om angiven formulärdata är korrekt
        if ($success) {

            // Om metod för att registrera användare returnerar true
            if ($user->registerUser()) {

                // Skapar sessionsvariabel
                $_SESSION['registerok556'] = "<p class='greenfivehundred'>Ditt konto har skapats och du är välkommen att logga in!</p>";

                // Skickar vidare till logga in-sidan
                header('Location: loginuser.php');
            } else {
                // Lagrar felmeddelande i variabel för utskrift på annat ställe
                $usernameTaken = "<p class='redfivehundred'>Användarnamnet är upptaget, testa ett annat!</p>";
            }
        } else {
            // Lagrar felmeddelande i variabel för utskrift på annat ställe
            $registerUserMessage = "<p class='redfivehundred'>Användarkontot har inte registrerats! Kontrollera värden och försök igen.</p>";
        }
    } else {
            // Lagrar felmeddelande i variabel för utskrift på annat ställe
            $passwordsDoesNotMatchMessage = "<p class='redfivehundred'>Lösenord stämmer inte överens!</p>";
    }
}
?>

                <h2>Skapa konto</h2>
                <p class="fivehundred">Har du redan ett konto? <a class="light" href="loginuser.php">Logga in</a>.</p><br>
                <?= $registerUserMessage ?>
              
                <section>
                    <h3>Ange användaruppgifter</h3>
                    <form action="register.php" method="post">
                        <div class="container">
                            <?= $setFirstnameMessage ?>

                            <div class="item">
                                <label for="firstname">Förnamn:</label>
                                <br>
                                <input type="text" id="firstname" name="firstname" pattern="[A-Öa-ö]{2,30}" title="Förnamn ska anges med 2-30 bokstäver. Mellanslag och specialtecken tillåts inte." value="<?= htmlspecialchars($firstname); ?>">
                            </div>
                            <br>
                            <?= $setLastnameMessage ?>

                            <div class="item">
                                <label for="lastname">Efternamn:</label>
                                <br>
                                <input type="text" id="lastname" name="lastname" pattern="[A-Öa-ö]{2,30}" title="Efternamn ska anges med 2-30 bokstäver. Mellanslag och specialtecken tillåts inte." value="<?= htmlspecialchars($lastname); ?>">
                            </div>
                            <br>
                            <?= $setUsernameMessage ?>
                            <?= $usernameTaken ?>

                            <div class="item">
                                <label for="username">Användarnamn: (5-30 små bokstäver och/eller siffror)</label>
                                <br>
                                <input type="text" id="username" name="username" pattern="[a-ö0-9]{5,30}" title="Användarnamn ska anges med 5-30 små bokstäver och/eller siffror. Mellanslag och specialtecken tillåts inte." value="<?= htmlspecialchars($username); ?>">
                            </div>
                            <br>
                            <?= $setPasswordMessage ?>

                            <div class="item">
                                <label for="password">Lösenord: (minst åtta tecken)</label>
                                <br>
                                <input type="password" id="password" name="password" title="Lösenord ska anges med minst åtta tecken.">
                                <div class="right">
                                    <input type="checkbox" id="showPassword" name="showPassword">
                                    <label for="showPassword">Visa lösenord</label>
                                </div>
                            </div>
                            <br>
                            <?= $passwordsDoesNotMatchMessage ?>

                            <div class="item">
                                <label for="verifypassword">Upprepa lösenord:</label>
                                <br>
                                <input type="password" id="verifypassword" name="verifypassword" title="Upprepat lösenord ska anges med samma tecken som ovan angivet lösenord.">
                                <div class="right">
                                    <input type="checkbox" id="showVerifyPassword" name="showVerifyPassword">
                                    <label for="showVerifyPassword">Visa lösenord</label>
                                </div>
                            </div>
                            <br><br>
                            <div class="item">
                                <input type="checkbox" id="agree" name="agree" required>
                                <label for="agree">Jag godkänner att mina användaruppgifter lagras för att ett konto ska kunna skapas.</label>
                            </div>
                        </div>
                        <input type="submit" value="Skapa konto">
                    </form>                                        
                </section>
<?php
include("includes/footer.php");
?>