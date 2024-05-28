<?php
/* Av Petra Ingemarsson */

include("includes/config.php");
$page_title = "Logga in som admin";
include("includes/header.php");
?>

                <h2>Logga in som administratör</h2>
                <?php
                // Kontroll om felmeddelande finns
                if (isset($_GET['error'])) {

                    // Skriver ut meddelande
                    echo "<p class='redfivehundred'>Du måste vara inloggad som behörig administratör för att kunna administrera denna webbplats!</p>";
                }

                // Sätter standardvärde för att variabler för utskrift av meddelanden inte ska ge felmeddelanden
                $setUsernameMessage = "";
                $setPasswordMessage = "";
                $loginAdminMessage = "";

                // Kontroll att formulärdata är angivet
                if (isset($_POST['username'])) {

                    // Lagrar formulärdata i variabler
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    // Skapar instans av klass
                    $user = new Bloguser();

                    // Variabel som anger om angiven formulärdata passerar kontroller eller inte
                    $success = true;

                    // Om metoden setUsername returnerar false pga felaktigt användarnamn
                    if (!$user->setUsername($username)) {

                        // Ändrar variabel till false
                        $success = false;

                        // Lagrar felmeddelande i variabel för utskrift på annat ställe
                        $setUsernameMessage = "<p class='redfivehundred'>Användarnamn måste anges!</p>";
                    }

                    // Om metoden setPassword returnerar false pga felaktigt lösenord
                    if (!$user->setPassword($password)) {

                        // Ändrar variabel till false
                        $success = false;

                        // Lagrar felmeddelande i variabel för utskrift på annat ställe
                        $setPasswordMessage = "<p class='redfivehundred'>Lösenord måste anges!</p>";
                    }

                    // Om angiven formulärdata är korrekt
                    if ($success) {

                        // Kontroll om användarnamn är admin och loginUser-metod returnerar true vid medskickat data
                        if ($username === "admin" and $user->loginUser($username, $password)) {

                            // Skapar sessionsvariabel
                            $_SESSION['loggedin556'] = "<p class='fivehundred'>Du är inloggad som " . $_SESSION['username556'] . ", välkommen!</p>";

                            // Skickar vidare till administrationssidan
                            header('Location: admin.php');
                        } else {
                            // Lagrar meddelande i variabel för utskrift på annat ställe
                            $loginAdminMessage = "<p class='redfivehundred'>Du saknar behörighet att administrera denna webbplats!</p>";
                        }
                    } else {
                        // Lagrar felmeddelande i variabel för utskrift på annat ställe
                        $loginAdminMessage = "<p class='redfivehundred'>Felaktigt användarnamn eller lösenord! Kontrollera värden och försök igen.</p>";
                    }
                }
                ?>
                <?= $loginAdminMessage ?>

                <section>
                    <h3>Ange användaruppgifter</h3>
                    <form action="login.php" method="post">
                        <div class="container">
                            <?= $setUsernameMessage ?>

                            <div class="item">
                                <label for="username">Användarnamn:</label>
                                <br>
                                <input type="text" id="username" name="username" pattern="[a-ö0-9]{5,30}" title="Användarnamn ska anges med 5-30 små bokstäver och/eller siffror.">
                            </div><br>
                            <?= $setPasswordMessage ?>

                            <div class="item">
                                <label for="password">Lösenord:</label>
                                <br>
                                <input type="password" id="password" name="password" title="Lösenord ska anges med minst åtta tecken.">
                                <div class="right">
                                    <input type="checkbox" id="showPassword" name="showPassword">
                                    <label for="showPassword">Visa lösenord</label>
                                </div>
                            </div>
                            <br><br>                            
                            <div class="item">
                                <input type="checkbox" id="agree" name="agree" required>
                                <label for="agree">Jag godkänner att mina användaruppgifter lagras för att inloggning ska kunna genomföras.</label>
                            </div>
                        </div>
                        <input type="submit" value="Logga in">
                    </form>
                </section>
<?php
include("includes/footer.php");
?>