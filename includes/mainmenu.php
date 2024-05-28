                <!-- Navigeringsmeny -->
                <nav class="mainmenu">
                    <!-- Stäng-knapp som visas om hamburgermenyn är utfälld -->
                    <button id="close-menu-btn" onclick="openOrCloseMenu()">Stäng<i
                            class="fa-solid fa-xmark"></i></button>
                    <ul>
                        <li><a href="index.php">Startsida</a></li>
                        <li><a href="posts.php">Blogginlägg</a></li>
                        <?php
                        /* Av Petra Ingemarsson */
                        
                        // Om användare inte är inloggad
                        if (!isset($_SESSION['username556'])) {

                            // Skriver ut länkar
                            echo "<li><a href='register.php'>Skapa konto</a></li>";
                            echo "<li><a href='loginuser.php'>Logga in</a></li>";
                        }

                        // Om inloggad användare
                        if (isset($_SESSION['username556'])) {
                            
                            // Skriver ut länk
                            echo "<li><a href='myposts.php'>Mitt konto</a></li>";
                        }

                        // Om inloggad administratör
                        if (isset($_SESSION['username556']) and $_SESSION['username556'] === "admin") {

                            // Skriver ut länk
                            echo "<li><a href='admin.php'>Administrera</a></li>";
                        }

                        // Om inloggad användare
                        if (isset($_SESSION['username556'])) {
                            
                            // Skriver ut länk
                            echo "<li><a href='logout.php'>Logga ut <i class='fa-solid fa-right-from-bracket'></i></a></li>";
                        }
                        ?>
                        
                    </ul>
                </nav>