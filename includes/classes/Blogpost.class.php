<?php
/* Av Petra Ingemarsson */

class Blogpost
{
    // Properties
    private $db;
    private $title;
    private $content;
    private $user;

    // Constructor med anslutning mot databas
    public function __construct()
    {
        // Ansluter till databas
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        // Kontroll om fel vid anslutning
        if ($this->db->connect_errno > 0) {

            // Skriver ut felmeddelande
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    // Set-metod för att lägga till titel
    public function setTitle(string $title): bool
    {
        // Kontroll att titel inte är tom
        if ($title != "") {

            // Saniterar angivet data
            $title = $this->db->real_escape_string($title);

            $this->title = $title;
            return true;
        } else {
            return false;
        }
    }

    // Set-metod för att lägga till innehåll
    public function setContent(string $content): bool
    {
        // Kontroll att innehåll inte är tomt
        if ($content != "") {

            // Saniterar angivet data
            $content = $this->db->real_escape_string($content);

            $this->content = $content;
            return true;
        } else {
            return false;
        }
    }

    // Set-metod för att lägga till användare
    public function setUser(string $user): bool
    {
        // Kontroll att user är medskickat
        if ($user) {

            // Saniterar data
            $user = $this->db->real_escape_string($user);

            $this->user = $user;
            return true;
        } else {
            return false;
        }
    }

    // Metod för att skapa nytt inlägg
    public function addPost(): bool
    {
        // SQL-fråga för att skicka data till databasen
        $sql = "INSERT INTO blogposts(title, content, user) VALUES('" . $this->title . "', '" . $this->content . "', '" . $this->user . "');";

        // Skickar SQL-fråga till servern och returnerar svaret
        return mysqli_query($this->db, $sql);
    }

    // Get-metod för att hämta samtliga inlägg från databasen
    public function getPosts(): array
    {
        // SQL-fråga för att läsa ut data från databasen sorterad efter id i fallande ordning
        $sql = "SELECT id, title, content, created, user, firstname, lastname FROM blogposts, blogusers WHERE user=username ORDER BY id desc;";


        // Skickar SQL-fråga till servern och lagrar resultat av utläst data i en variabel
        $result = mysqli_query($this->db, $sql);

        // Returnerar data som en associativ array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Get-metod för att hämta egenskapade inlägg från databasen
    public function getPostsByUser(string $user): array
    {
        // Saniterar data
        $user = $this->db->real_escape_string($user);

        // SQL-fråga för att ut läsa data från databasen sorterad efter id i fallande ordning
        $sql = "SELECT id, title, content, created, user, firstname, lastname FROM blogposts, blogusers WHERE user=username AND user='$user' ORDER BY id desc;";

        // Skickar SQL-fråga till servern och lagrar resultat av utläst data i en variabel
        $result = mysqli_query($this->db, $sql);

        // Returnerar data som en associativ array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Get-metod för att hämta specifikt inlägg från databasen
    public function getPostById(int $id): array
    {
        // Konverterar till heltal
        $id = intval($id);

        // SQL-fråga för att läsa ut data från databasen utifrån id
        $sql = "SELECT id, title, content, created, user, firstname, lastname FROM blogposts, blogusers WHERE user=username AND id=$id;";

        // Skickar SQL-fråga till servern och lagrar resultat av utläst data i en variabel
        $result = mysqli_query($this->db, $sql);

        // Returnerar data som en associativ array
        return $result->fetch_assoc();
    }

    // Metod för att uppdatera inlägg i databasen
    public function updatePost(int $id): bool
    {
        // SQL-fråga för att ändra inlägg i databasen utifrån id
        $sql = "UPDATE blogposts SET title='" . $this->title . "', content='" . $this->content . "' WHERE id=$id;";

        // Skickar SQL-fråga till servern och returnerar svaret
        return mysqli_query($this->db, $sql);
    }

    // Metod för att radera inlägg i databasen
    public function deletePost(int $id): bool
    {
        // SQL-fråga för att radera inlägg utifrån id
        $sql = "DELETE FROM blogposts WHERE id=$id;";

        // Skickar SQL-fråga till servern och returnerar svaret
        return mysqli_query($this->db, $sql);
    }

    // Destructor för att stänga anslutning till databas
    public function __destruct()
    {
        // Stänger anslutning
        mysqli_close($this->db);
    }
}
?>