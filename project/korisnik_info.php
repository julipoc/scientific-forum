<?php
    session_start();

    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT * FROM korisnik";
    $rezultat = izvrsiUpit($veza, $upit);

    zatvoriVezuNaBazu($veza);

?>

<!DOCTYPE html>
<html>
    <head>
		<title>Znanstveni forum</title>
		<meta charset="utf-8">
		<meta name="autor" content="Julija Počekal">
		<meta name="datum" content="13.01.2022.">
		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
    <body>

        <?php
            include_once "navigacija.php";    
        ?>

        <section id="korisnik_section">
            <?php					
                if(isset($rezultat)) {
                    while($red = mysqli_fetch_array($rezultat)){
                        if($red['korisnik_id'] == $_GET["id"]) {
                            echo "<img src='{$red['slika']}' alt='{$red['ime']} {$red['prezime']}' width='150' height='250' title='{$red['ime']} {$red['prezime']}'> ";
                            echo "<div>";
                            echo "<h1>{$red['ime']} {$red['prezime']}</h1>";

                            if($red['tip_korisnika_id'] == 0) {
                                $tip = "administrator";
                            } else if($red['tip_korisnika_id'] == 1) {
                                $tip = "znanstvenik";
                            } else {
                                $tip = "korisnik";
                            }

                            echo "<p>($tip)</p>";
                            echo "<p>KORISNIČKO IME: {$red['korime']}</p>";
                            echo "<p>EMAIL: {$red['email']}</p>";

                            if($red['titula']) {
                                echo "<p>TITULA: {$red['titula']}</p>";
                            }

                            if($red['radno_mjesto']) {
                                echo "<p>RADNO MJESTO: {$red['radno_mjesto']}</p>";
                            }
                            
                            if($red['opis']) {
                                echo "<p>OPIS: {$red['opis']}</p>";
                            }
                            
                            echo "</div>";
                        }
                    }
                }
            ?>
        </section>
    </body>     
</html>