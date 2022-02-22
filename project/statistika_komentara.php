<?php
    session_start();
    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT COUNT(*) as broj_komentara, z.naziv FROM komentar k, znanstveno_podrucje z WHERE k.znanstveno_podrucje_id=z.znanstveno_podrucje_id GROUP BY z.znanstveno_podrucje_id";
    $rezultat = izvrsiUpit($veza, $upit);

    zatvoriVezuNaBazu($veza);
?>

<!DOCTYPE html>
<html>
    <head>
		<title>Znanstveni forum - statistika</title>
		<meta charset="utf-8">
		<meta name="autor" content="Julija Počekal">
		<meta name="datum" content="13.01.2022.">
		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
    <body>

        <?php
            include_once "navigacija.php";    
        ?>
        
        <h1 id="statistika_naslov">STATISTIKA KOMENTARA PO PODRUČJU</h1>
        <section id="statistika_section">
            <table border="1">
                <thead>
                    <tr>
                        <th>Znanstveno područje</th>
                        <th>Broj komentara</th>
                    </tr>
                </thead>
                <tbody>
                <?php				
                    if(isset($rezultat)) {
                        while($red = mysqli_fetch_array($rezultat)){
                            echo "<tr>";
                            echo "<td>{$red['naziv']}</td>";
                            echo "<td id='td_broj'>{$red['broj_komentara']}</td>";
                            echo "</tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
        </section>
    </body>
</html>