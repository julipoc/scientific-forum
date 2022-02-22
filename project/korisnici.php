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
		<title>Znanstveni forum - korisnici</title>
		<meta charset="utf-8">
		<meta name="autor" content="Julija Počekal">
		<meta name="datum" content="13.01.2022.">
		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
    <body>

        <?php
            include_once "navigacija.php";    
        ?>
        
        <h1 id="korisnici_naslov">KORISNICI</h1>
        <section id="korisnici_section">
            <div>
                <a id="dodaj_kor" href="dodaj_korisnika.php">Dodaj korisnika</a>
            </div>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID korisnika</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <?php
                            if(isset($_SESSION["id"])) {
                                if($_SESSION["tip"] == 0) {
                                    echo "<th></th>";
                                }                           
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    
                <?php				
                    if(isset($rezultat)) {
                        while($red = mysqli_fetch_array($rezultat)){
                            echo "<tr>";
                            echo "<td id='td_id'>{$red['korisnik_id']}</td>";
                            echo "<td>{$red['ime']}</td>";
                            echo "<td>{$red['prezime']}</td>";
                            echo "<td id='td_az2'><a href='azuriraj_korisnika.php?id={$red['korisnik_id']}'>Ažuriraj</a></td>";

                            echo "</tr>";
                        }
                    }
                ?>     
                </tbody>
            </table>
        </section>
    </body>  
</html>
