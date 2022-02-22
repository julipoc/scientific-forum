<?php
    session_start();

    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT k.korisnik_id, k.ime, k.prezime, k.titula, k.radno_mjesto, z.naziv, z.znanstveno_podrucje_id,zp.moderator_id FROM korisnik k, znanstveno_podrucje z, zahtjev_podrucja zp WHERE zp.moderator_id=k.korisnik_id AND zp.znanstveno_podrucje_id=z.znanstveno_podrucje_id AND zp.status=2";    
    $rezultat = izvrsiUpit($veza, $upit);

    if(isset($_POST["odbij"])) {
        $upit1 = "UPDATE zahtjev_podrucja SET zahtjev_podrucja.status=0 WHERE moderator_id='{$_GET['mod_id']}' AND znanstveno_podrucje_id='{$_GET['znan_id']}'";
        $rezultat1 = izvrsiUpit($veza, $upit1);
        header("Location: zahtjevi.php");
    }

    if(isset($_POST["prihvati"])) {
        $upit1 = "UPDATE zahtjev_podrucja SET zahtjev_podrucja.status=1 WHERE moderator_id='{$_GET['mod_id']}' AND znanstveno_podrucje_id='{$_GET['znan_id']}'";
        $rezultat1 = izvrsiUpit($veza, $upit1);

        $upit2 = "UPDATE korisnik SET znanstveno_podrucje_id='{$_GET['znan_id']}' WHERE korisnik_id='{$_GET['kor_id']}'";
        $rezultat2 = izvrsiUpit($veza, $upit2);

        header("Location: zahtjevi.php");
    }

    zatvoriVezuNaBazu($veza);
?>

<!DOCTYPE html>
<html>
    <head>
		<title>Znanstveni forum - zahtjevi</title>
		<meta charset="utf-8">
		<meta name="autor" content="Julija Počekal">
		<meta name="datum" content="13.01.2022.">
		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
    <body>

        <?php
            include_once "navigacija.php";    
        ?>

        <h1 id="zahtjevi_naslov">ZAHTJEVI</h1>
        <section id="zahtjevi_section">
            <table border="1">
                <thead>
                    <tr>
                        <th>Ime i prezime</th>
                        <th>Titula</th>
                        <th>Radno mjesto</th>
                        <th>Zahtjev za područje</th>
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
                            echo "<td>{$red['ime']} {$red['prezime']}</td>";
                            echo "<td>{$red['titula']}</td>";
                            echo "<td>{$red['radno_mjesto']}</td>";
                            echo "<td>{$red['naziv']}</td>";
                            echo "<form id='pregled_zahtjeva' name='pregled_zahtjeva' method='post' 
                            action='zahtjevi.php?znan_id={$red['znanstveno_podrucje_id']}&mod_id={$red['moderator_id']}&kor_id={$red['korisnik_id']}'>";
                        
                            echo "<td><input name='prihvati' type='submit' value='Prihvati'/> <input name='odbij' type='submit' value='Odbij'/></td>";
                            
                            echo "</form>";

                            echo "</tr>";
                        }
                    }
                ?>       
                </tbody>
            </table>
        </section>
    </body>     
</html>