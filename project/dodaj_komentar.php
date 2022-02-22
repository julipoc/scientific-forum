<?php
	session_start();

	include_once("baza_funkcije.php");
	$veza = spojiSeNaBazu();

	$upit_korisnik = "SELECT * FROM korisnik WHERE korisnik_id='{$_SESSION['id']}'";
	$rezultat_korisnik = izvrsiUpit($veza, $upit_korisnik);

	if(isset($rezultat_korisnik)) {
		while($red = mysqli_fetch_array($rezultat_korisnik)){
			$korisnik_podrucje = $red['znanstveno_podrucje_id'];
		}
	}

	if(isset($_POST["submit"])) {
		$greska = "";
		if(isset($_POST['komentar']) && !empty($_POST['komentar'])) {
			if($korisnik_podrucje == $_POST['podrucje']) {
				$kom_znanstvenika = 1;
			} else {
				$kom_znanstvenika = 0;
			}

			$upit = "INSERT INTO komentar (znanstveno_podrucje_id, korisnik_id, sadrzaj, datum_vrijeme_kreiranja, komentar_znanstvenika) VALUES ('{$_POST['podrucje']}','{$_SESSION['id']}', '{$_POST['komentar']}',  date('d.m.Y H:i:s'), '$kom_znanstvenika')";      
			$rezultat = izvrsiUpit($veza, $upit);	
			header("Location: znanstvena_podrucja.php");
		} else {
			$greska = "Komentar nije unesen!";
		}
	}

	$upit = "SELECT * FROM znanstveno_podrucje";
	$rezultat = izvrsiUpit($veza, $upit);

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

		<section id="dodaj_kom">
			<h1>DODAJ KOMENTAR</h1>			
			<form name="obrazac" method="post" action="dodaj_komentar.php">

				<label for="podrucje">Znanstveno područje<label><br>
				<select name="podrucje" id="podrucje">
					<?php
						if(isset($rezultat)) {
							while($red = mysqli_fetch_array($rezultat)){
								echo "<option value='{$red['znanstveno_podrucje_id']}'>{$red['naziv']}</option>";
							}
						}
				?>
				</select>
				<br>

                <label for="komentar">Komentar<label><br>
				<textarea name="komentar" placeholder="Napiši komentar..."
				rows="8" cols="37" maxlength="1000"></textarea>
				<br>

				<input name="submit" type="submit" value="Dodaj"/>
				<input id="reset" class="pok" type="reset" name="reset" value="Obriši" />
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
