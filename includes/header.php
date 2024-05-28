<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_title . $divider . $page_title; ?></title>
    <!-- Länkar in style.css -->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!-- Länkar in ikon-kit för menyknappen -->
    <script src="https://kit.fontawesome.com/b074591ff2.js" crossorigin="anonymous"></script>
    <!-- Länkar in Ckeditor-plugin för textarea -->
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
</head>

<body>
    <div id="page-container">
        <div id="content-wrap">
            <!-- Sidhuvud -->
            <header>
                <!-- Logotyp -->
                <h1><a href="index.php">Soundbloggen</a></h1>
                <!-- Knapp för att öppna hamburgermeny -->
                <button id="open-menu-btn" onclick="openOrCloseMenu()">Meny<i class="fa-solid fa-bars"></i></button>
                <?php include("includes/mainmenu.php"); ?>
                
            </header>
            <!-- Huvudinnehåll -->
            <main>