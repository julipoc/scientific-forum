<?php
    session_start();

    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT * FROM znanstveno_podrucje";
    $rezultat_tipovi = izvrsiUpit($veza, $upit);

    $upit_broj = "SELECT MAX(znanstveno_podrucje_id) FROM znanstveno_podrucje";
    $rezultat_broj = izvrsiUpit($veza, $upit_broj);
                   
    if(isset($rezultat_broj)) {
        while($red = mysqli_fetch_array($rezultat_broj)){
            $id_broj = max($red) + 1;
        }
    }

    if(isset($_POST["dodaj"])) {
        $greska = "";
        if(isset($_POST['opis']) && !empty($_POST['opis']) && isset($_POST['naziv']) && !empty($_POST['naziv'])) {
            $upit = "INSERT INTO znanstveno_podrucje (znanstveno_podrucje_id, naziv, opis) VALUES ('{$id_broj}', '{$_POST['naziv']}', '{$_POST['opis']}')";      
            $rezultat = izvrsiUpit($veza, $upit);	
            header("Location: znanstvena_podrucja.php");
        } else {
			$greska = "Opis i/ili naziv nisu uneseni!";
		}
    }
    zatvoriVezuNaBazu($veza);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Znanstveni forum</title>
		<meta charset="utf-8">
		<meta name="autor" content="Julija Počekal">
		<meta name="datum" content="13.01.2022.">		
		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
	<body>
		<?php
			include "navigacija.php";
		?>

        <section id="dodaj_podrucje">
            <h1>DODAJ ZNANSTVENO PODRUČJE</h1>
            <form method="post" action="dodaj_znanstveno_podrucje.php">
    
                <label for="naziv">Naziv<label><br>
                <input name="naziv" type="text"/>
                <br>

                <label for="opis">Opis<label><br>
                <textarea name="opis" placeholder="Napiši opis znanstvenog područja..."
				rows="8" cols="37" maxlength="1000"></textarea>
                <br>

                <input name="dodaj" type="submit" value="Dodaj"/>
                <input id="reset" type="reset" name="reset"  
                value="Obriši" />
            </form>

            <div>
                <?php               
					if(isset($greska)) {
						echo "<p style='color:red;'>$greska</p>";
					}              
                ?>
            </div>
		</section>
	</body>
</html>
