<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
		<title>Znanstveni forum - profil</title>
		<meta charset="utf-8">
		<meta name="autor" content="Julija Počekal">
		<meta name="datum" content="13.01.2022.">
		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
    <body>

        <?php
            include_once "navigacija.php";    
        ?>
        
        <h1 id="profil_naslov">INFORMACIJE O MENI</h1>
        <section id="profil_section">
            <?php
                if(isset($_SESSION["id"])) {
                    echo "<div id='profile1'>";
                    echo "<img src='{$_SESSION['slika']}' width='150' height='250'>";
                    echo "<h4>{$_SESSION['ime']} {$_SESSION['prezime']}</h4>";

                    if($_SESSION['tip'] == 0) {
                        $tip = "administrator";
                    } else if($_SESSION['tip'] == 1) {
                        $tip = "znanstvenik";
                    } else {
                        $tip = "korisnik";
                    }
                    echo "<p>$tip</p>";
                    echo "</div>";

                    echo "<div id='profil2'>";
                    echo "<p>Korisničko ime: {$_SESSION['korime']}</p>";
                    echo "<p>Email: {$_SESSION['email']}</p>";

                    if($_SESSION['titula']) {
                        echo "<p>Titula: {$_SESSION['titula']}</p>";
                    }

                    if($_SESSION['radno_mjesto']) {
                        echo "<p>Radno mjesto: {$_SESSION['radno_mjesto']}</p>";
                    }
                    
                    if($_SESSION['opis']) {
                        echo "<p>Opis: {$_SESSION['opis']}</p>";
                    }

                    echo "<br><a href='azuriraj_podatke.php'>Ažuriraj podatke</a><br><br> ";

                    if($tip == "znanstvenik") {
                        echo "<a href='promjena_znanstvenog_podrucja.php'>Promijeni područje</a>";
                    }
                    echo "</div>";
                }
            ?>
            
        </section>
    </body>
</html>