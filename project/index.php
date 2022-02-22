<?php
    session_start();

    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT * FROM korisnik ORDER BY korisnik.prezime DESC";
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
        <meta name="viewport" content="width=device-wodth, initial-scale=1.0">

		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
    <body>

        <?php
            include_once "navigacija.php";    
        ?>
        
        <h1 id="galerija_naslov">GALERIJA ZNANSTVENIKA</h1>
        <section id="galerija_znanstvenika">           
            
            <?php					
                if(isset($rezultat)) {
                    while($red = mysqli_fetch_array($rezultat)){
                        $titula = "";
                        if($red['titula']) {
                            $titula = ", " . $red['titula'];
                        }
                        
                        if(isset($_SESSION["id"])) {
                            echo "<a href='korisnik_info.php?id={$red['korisnik_id']}' target='_blank'><img src='{$red['slika']}' alt='{$red['ime']} {$red['prezime']}' title='{$red['ime']} {$red['prezime']}{$titula}'></a> ";
                        } else {
                            echo "<img src='{$red['slika']}' alt='{$red['ime']} {$red['prezime']}' title='{$red['ime']} {$red['prezime']}{$titula}'> "; 
                        }
                    }                  
                }
            ?>          
        </section>
    </body>
    <footer>&copy; 2022 Znanstveni forum</footer>
</html>