<?php
    session_start();
    
    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT * FROM korisnik";
    $rezultat = izvrsiUpit($veza, $upit);

    $upit2 = "SELECT * FROM korisnik WHERE korisnik_id='{$_GET['kor_id']}' AND znanstveno_podrucje_id='{$_GET['id']}'";
    $rezultat2 = izvrsiUpit($veza, $upit2);

    $upit3 = "SELECT * FROM znanstveno_podrucje WHERE znanstveno_podrucje_id='{$_GET['id']}'";
    $rezultat3 = izvrsiUpit($veza, $upit3);
    $rezultat3 = mysqli_fetch_array($rezultat3);

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

        <section id="znanstvenici_section">
                <?php					
                    if(isset($rezultat2)) {
                        while($red = mysqli_fetch_array($rezultat2)){
                                echo "<img src='{$red['slika']}' alt='{$red['ime']} {$red['prezime']}' width='150' height='250' title='{$red['ime']} {$red['prezime']}'> ";

                                echo "<div>";
                                echo "<h1>ZNANSTVENIK</h1>";
                                echo "<h3>{$red['ime']} {$red['prezime']}</h3>";

                                echo "<p><span>KORISNIČKO IME:</span> {$red['korime']}</p>";

                                echo "<p><span>EMAIL:</span> {$red['email']}</p>";

                                if($red['titula']) {
                                    echo "<p><span>TITULA: </span>{$red['titula']}</p>";
                                }

                                if($red['radno_mjesto']) {
                                    echo "<p><span>RADNO MJESTO: </span>{$red['radno_mjesto']}</p>";
                                }

                                if($red['opis']) {
                                    echo "<p><span>OPIS: </span>{$red['opis']}</p>";
                                }

                                echo "<p><span>ZNANSTVENO PODRUČJE: </span>{$rezultat3['naziv']}</p>";
                                echo "</div>";
                        }
                    }
                ?>
        </section>
    </body>    
</html>