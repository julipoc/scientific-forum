<?php
	session_start();

	if(isset($_GET["odjava"])){
		unset($_SESSION["id"]);
		session_destroy();
		header("Location: index.php");
	}

	include_once("baza_funkcije.php");
	$veza = spojiSeNaBazu();

	if(isset($_POST["submit"])) {
		$greska = "";
		$poruka = "";
		$korime = $_POST["korIme"];
		if(isset($korime) && !empty($korime) && isset($_POST["lozinka"]) && !empty($_POST["lozinka"])) {

			$upit = "SELECT * FROM korisnik WHERE korime ='{$korime}' AND lozinka ='{$_POST["lozinka"]}' ";      
			$rezultat = izvrsiUpit($veza, $upit);
		
			$prijava = false;
			while($red = mysqli_fetch_array($rezultat)) {
				$prijava = true;
				$_SESSION["id"] = $red["korisnik_id"];
				$_SESSION["znanstveno_podrucje_id"] = $red["znanstveno_podrucje_id"];
				$_SESSION["tip"] = $red["tip_korisnika_id"];
				$_SESSION["korime"] = $red["korime"];
				$_SESSION["ime"] = $red["ime"];
				$_SESSION["prezime"] = $red["prezime"];
				$_SESSION["email"] = $red["email"];
				$_SESSION["slika"] = $red["slika"];
				$_SESSION["titula"] = $red["titula"];
				$_SESSION["radno_mjesto"] = $red["radno_mjesto"];
				$_SESSION["opis"] = $red["opis"];
			}		
					
			if($prijava) {
				setcookie("moj_kolacic", $poruka);
				header("Location: index.php");
				exit();
			} else {
				$greska = "Korisničko ime i/ili lozinka se ne podudaraju!";
			}
		} else {
			$greska = "Korisničko ime i/ili lozinka nisu uneseni!";
		}
	}

	zatvoriVezuNaBazu($veza);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Znanstveni forum - prijava</title>
		<meta charset="utf-8">
		<meta name="autor" content="Julija Počekal">
		<meta name="datum" content="13.01.2022.">		
		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
	<body>
		<?php
			include "navigacija.php";
		?>

		<section id="obrazac_prijava">
			<h1>PRIJAVI SE</h1>
			<form name="obrazac" method="post" 
			action="prijava.php"> 

				<label for="korIme">Korisničko ime<label><br>
				<input name="korIme" type="text" />
				<br>

                <label for="lozinka" id="loz">Lozinka<label><br>
				<input name="lozinka" type="password" id="loz2"/>
				<br>

				<input name="submit" type="submit" value="Prijavi se"/>
				<input class="pok" type="reset" name="reset"  
				value="Odustani" />
			</form>

            <div>
                <?php               
					if(isset($greska)) {
						echo "<p style='color:red;'>$greska</p>";
					}

					if(isset($_COOKIE["moj_kolacic"])) {
						echo "<p style='color:green;'>{$_COOKIE['moj_kolacic']}</p>";
					}        
					       
                ?>
            </div>
		</section>
	</body>
</html>
