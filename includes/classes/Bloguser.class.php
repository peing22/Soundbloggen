<?php
/* Av Petra Ingemarsson */

class Bloguser
{
    // Properties
    private $db;
    private $firstname;
    private $lastname;
    private $username;
    private $password;

    // Constructor med anslutning mot databas
    public function __construct()
    {
        // Ansluter till databas
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        // Kontroll om fel vid anslutning
        if ($this->db->connect_errno > 0) {

            // Felmeddelande
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    // Set-metod för att lägga till förnamn
    public function setFirstname(string $firstname): bool
    {
        // Kontroll att förnamn består av minst två, max 30 tecken
        if (mb_strlen($firstname) >= 2 and mb_strlen($firstname) <= 30) {

            // Saniterar angivet data
            $firstname = $this->db->real_escape_string($firstname);

            $this->firstname = $firstname;
            return true;
        } else {
            return false;
        }
    }

    // Set-metod för att lägga till efternamn
    public function setLastname(string $lastname): bool
    {
        // Kontroll att efternamn består av minst två, max 30 tecken
        if (mb_strlen($lastname) >= 2 and mb_strlen($lastname) <= 30) {

            // Saniterar angivet data
            $lastname = $this->db->real_escape_string($lastname);

            $this->lastname = $lastname;
            return true;
        } else {
            return false;
        }
    }

    // Set-metod för att lägga till användarnamn
    public function setUsername(string $username): bool
    {
        // Kontroll att användarnamn består av minst fem, max 30 tecken
        if (mb_strlen($username) >= 5 and mb_strlen($username) <= 30) {

            // Saniterar angivet data
            $username = $this->db->real_escape_string($username);

            $this->username = $username;
            return true;
        } else {
            return false;
        }
    }

    // Set-metod för att lägga till lösenord
    public function setPassword(string $password): bool
    {
        // Kontroll att lösenord består av minst åtta tecken
        if (mb_strlen($password) >= 8) {

            // Hashar lösenord
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $this->password = $hashedPassword;
            return true;
        } else {
            return false;
        }
    }

    // Metod för att registrera ny användare i databasen
    public function registerUser(): bool
    {
        // SQL-fråga för att lista ut om användarnamn existerar 
        $sql = "SELECT * FROM blogusers WHERE username='$this->username';";

        // Skickar SQL-fråga till servern och lagrar resultat av utläst data i en variabel
        $result = mysqli_query($this->db, $sql);

        // Om SQL-frågan returnerar ett värde
        if (mysqli_num_rows($result) > 0) {

            return false;
        } else {
            // SQL-fråga för att skapa användare
            $sql = "INSERT INTO blogusers(firstname, lastname, username, password) VALUES('$this->firstname', '$this->lastname', '$this->username', '$this->password');";

            // Skickar SQL-fråga till servern och lagrar resultat av utläst data i en variabel
            $result = mysqli_query($this->db, $sql);

            return true;
        }
    }

    // Metod för att logga in användare
    public function loginUser(string $username, string $password): bool
    {
        // SQL-fråga för att kontrollera användarnamn
        $sql = "SELECT * FROM blogusers WHERE username='$this->username';";

        // Skickar SQL-fråga till servern och lagrar resultat av utläst data i en variabel
        $result = mysqli_query($this->db, $sql);

        // Kontroll om frågan gav ett svar
        if ($result->num_rows > 0) {

            // Läser ut rad som en associativ array
            $row = $result->fetch_assoc();

            // Läser ut lösenord
            $storedPassword = $row['password'];

            // Kontrollerar om inmatat lösenord stämmer överens med lagrat lösenord
            if (password_verify($password, $storedPassword)) {

                // Skapar sessionsvariabel som lagrar användarnamn
                $_SESSION['username556'] = $username;

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Metod som kontrollerar om användare är inloggad
    public function loggedIn(): bool
    {
        // Om sessionsvariabel existerar
        if (isset($_SESSION['username556'])) {
            return true;
        } else {
            return false;
        }
    }

    // Get-metod för att hämta samtliga användare från databasen
    public function getUsers(): array
    {
        // SQL-fråga för att läsa ut data från databasen
        $sql = "SELECT * FROM blogusers ORDER BY firstname;";

        // Skickar SQL-fråga till servern och lagrar resultat av utläst data i en variabel
        $result = mysqli_query($this->db, $sql);

        // Returnerar data som en associativ array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Get-metod för att hämta specifik författare från databasen
    public function getAuthor($username): string
    {
        // Saniterar angivet data
        $username = $this->db->real_escape_string($username);

        // SQL-fråga för att läsa ut data från databasen
        $sql = "SELECT * FROM blogusers WHERE username='$username';";

        // Skickar SQL-fråga till servern och lagrar resultat av utläst data i en variabel
        $result = mysqli_query($this->db, $sql);

        // Läser ut rad som en associativ array
        $row = $result->fetch_assoc();

        // Läser ut förnamn
        $storedFirstname = $row['firstname'];

        // Läser ut förnamn
        $storedLastname = $row['lastname'];

        // Skapar variabel som lagrar författare (förnamn och efternamn)
        $author = $storedFirstname . " " . $storedLastname;

        // Returnerar data som en textsträng
        return $author;
    }

    // Metod för att radera användarkonto och eventuella inlägg
    public function deleteUser($username): bool
    {
        // Villkor för konto som inte får raderas
        if ($username === "admin") {
            return false;
        } else {
            // Saniterar angivet data
            $username = $this->db->real_escape_string($username);

            // SQL-frågor för att radera data från databasen
            $sql = "DELETE FROM blogusers WHERE username='$username';";
            $sql .= "DELETE FROM blogposts WHERE user='$username';";

            // Skickar SQL-frågor till servern
            if ($this->db->multi_query($sql)) {
                return true;
            }
        }
    }

    // Destructor för att stänga anslutning till databas
    public function __destruct()
    {
        // Stänger anslutning
        mysqli_close($this->db);
    }
}
