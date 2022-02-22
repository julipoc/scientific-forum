<?php
    session_start();

    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT * FROM korisnik";
    $rezultat = izvrsiUpit($veza, $upit);

    $upit_broj = "SELECT MAX(korisnik_id) FROM korisnik ORDER BY korisnik_id DESC";
    $rezultat_broj = izvrsiUpit($veza, $upit_broj);
                  
    if(isset($rezultat_broj)) {
        while($red = mysqli_fetch_array($rezultat_broj)){
            $id_broj = max($red) + 1;
        }
    }


    if(isset($_POST["dodaj"])) {
        if(isset($_POST['korime']) && !empty($_POST['korime']) && isset($_POST['lozinka']) && !empty($_POST['lozinka'])) {
            $upit = "INSERT INTO korisnik (korisnik_id, tip_korisnika_id, ime, prezime, korime, email, lozinka, titula, radno_mjesto, opis) VALUES ('{$id_broj}','{$_POST['tip_id']}', '{$_POST['ime']}', '{$_POST['prezime']}', '{$_POST['korime']}', '{$_POST['email']}', '{$_POST['lozinka']}', '{$_POST['titula']}', '{$_POST['radno_mjesto']}', '{$_POST['opis']}')";      
            $rezultat = izvrsiUpit($veza, $upit);	
            header("Location: korisnici.php");
        } else {
			$greska = "Korisničko ime i/ili lozinka nisu uneseni!";
		}
    }

    $upit = "SELECT * FROM tip_korisnika";
    $rezultat_tipovi = izvrsiUpit($veza, $upit);

    $upit = "SELECT * FROM znanstveno_podrucje";
    $rezultat_podrucja = izvrsiUpit($veza, $upit);

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

        <section id="dodaj_korisnika">
            <h1>DODAJ KORISNIKA</h1>
            <form name="obrazac_dodavanje_korisnika" method="post" 
            action="dodaj_korisnika.php">
                  
                <label for="ime">Ime:</label>
                <input name="ime" type="text"/><br>

                <label for="prezime">Prezime:</label>
                <input name="prezime" type="text"/><br>
   
                <label for="korime">Korisničko ime:</label>
                <input name="korime" type="text" /><br>
 
                <label for="lozinka">Lozinka:</label>
                <input name="lozinka" type="password"/><br>

                <label for="email">Email:</label>
                <input name="email" type="email"/><br>

                <label for="titula">Titula:</label>
                <input name="titula" type="text" /><br>

                <label for="radno_mjesto">Radno mjesto:</label>
                <input name="radno_mjesto" type="text" /><br>
           
                <label for="opis">Opis:</label>
                <input name="opis" type="text" /><br>
                     
                <label for="tip_id">Tip:</label>
                <select name="tip_id">
                    <?php
                        while($red = mysqli_fetch_array($rezultat_tipovi)){
                            echo "<option value='{$red["tip_korisnika_id"]}'>{$red["naziv"]}</option>";

                        }
                    ?>
                </select><br>
                        
                <input name="dodaj" type="submit" value="Dodaj"/>
                <input type="reset" name="reset"  
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
