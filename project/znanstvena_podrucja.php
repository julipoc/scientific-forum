<?php
    session_start();

    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT * FROM znanstveno_podrucje";
    $rezultat = izvrsiUpit($veza, $upit);

    zatvoriVezuNaBazu($veza);
?>

<!DOCTYPE html>
<html>
    <head>
		<title>Znanstveni forum - znanstvena područja</title>
		<meta charset="utf-8">
		<meta name="autor" content="Julija Počekal">
		<meta name="datum" content="13.01.2022.">
		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
    <body>

        <?php
            include_once "navigacija.php";    
        ?>
        
        <h2 id="znanstvena_podrucja_naslov">ZNANSTVENA PODRUČJA</h2>
        <section id="znanstvena_podrucja_section">      
            <div>
                <a href="dodaj_komentar.php" id="dodaj_kom_gumb">Dodaj komentar</a>
                
                <?php
                    if(isset($_SESSION["id"])) {          
                        if($_SESSION["tip"] == 0) {
                            echo '<a href="dodaj_znanstveno_podrucje.php">Dodaj znanstveno područje</a> ';
                            
                        }
                    }
                ?>
            </div>

            <table border="1">
                <thead>
                    <tr>
                        <th>Znanstveno područje</th>
                        <th>Opis</th>
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
                            echo "<td><a href='komentari.php?id={$red['znanstveno_podrucje_id']}&naziv={$red['naziv']}'>{$red['naziv']}</td>";
                            echo "<td>{$red['opis']}</td>";

                            if(isset($_SESSION["id"])) {          
                                if($_SESSION["tip"] == 0) {
                                    echo "<td id='td_az'><a href='azuriraj_znanstveno_podrucje.php?id={$red['znanstveno_podrucje_id']}'>Ažuriraj</a></td>";
                                }
                            }
                            echo "</tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
        </section>
    </body> 
</html>


