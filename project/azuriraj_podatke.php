<?php
    session_start();

    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();
    $id_korisnika = $_SESSION["id"];

    if(isset($_POST["submit"])) {
        $greska = "";
        $filename = "";
        $tempname = $_FILES["slika"]["tmp_name"];
        $type = $_FILES['slika']['type'];
        $folder = "";
        
        if ($type == "") {
            $filename = $_SESSION["slika"];
            $folder = $filename;
        } else if ($type != "image/jpeg") {
            echo "Slika mora biti jpg formata!";

        } else {
            $filename = $_FILES["slika"]["name"];
            $folder = "korisnici/".$filename;
            move_uploaded_file($tempname, $folder);
        }

        $_SESSION["ime"] = $_POST["ime"];
        $_SESSION["prezime"] = $_POST["prezime"];
        $_SESSION["korime"] = $_POST["korime"];
        $_SESSION["lozinka"] = $_POST["lozinka"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["titula"] = $_POST["titula"];
        $_SESSION["radno_mjesto"] = $_POST["radno_mjesto"];
        $_SESSION["opis"] = $_POST["opis"];
        $_SESSION["slika"] = $folder;
        
        if(isset($_POST["lozinka"]) && !empty($_POST["lozinka"])) {
            $upit = "UPDATE korisnik SET ime='{$_POST['ime']}', prezime='{$_POST['prezime']}', korime='{$_POST['korime']}', lozinka='{$_POST['lozinka']}',email='{$_POST['email']}', titula='{$_POST['titula']}', radno_mjesto='{$_POST['radno_mjesto']}', opis='{$_POST['opis']}', slika='$folder' WHERE korisnik_id='{$id_korisnika}'";
            $rezultat = izvrsiUpit($veza, $upit);  
            header("Location: profil.php");
        } else {
			$greska = "Unesite lozinku!";
		}  
    }

    $upit = "SELECT * FROM korisnik WHERE korisnik_id='{$id_korisnika}'";
    $rezultat = izvrsiUpit($veza, $upit);
    $rezultat_ispis = mysqli_fetch_assoc($rezultat);

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

        <section id="azuriranje_podataka">
            <h1>AŽURIRAJ PODATKE</h1>
            <form name="obrazac_azuriranje" method="post" 
            action="azuriraj_podatke.php" enctype="multipart/form-data">

                <label for="ime">Ime:</label>
                <input name="ime" type="text" value="<?php echo $rezultat_ispis['ime'];?>"/>
                <br>

                <label for="prezime">Prezime:</label>
                <input name="prezime" type="text" value="<?php echo $rezultat_ispis['prezime'];?>"/>
                <br>

                <label for="korime">Korisničko ime:</label>
                <input name="korime" type="text" value="<?php echo $rezultat_ispis['korime'];?>"/>
                <br>

                <label for="lozinka">Lozinka:</label>
                <input name="lozinka" type="password" value=""<?php echo $rezultat_ispis['lozinka']?>/><br>

                <label for="email">Email:</label>
                <input name="email" type="email" value="<?php echo $rezultat_ispis['email'];?>"/>
                <br>

                <label for="titula">Titula:</label>
                <input name="titula" type="text" value="<?php echo $rezultat_ispis['titula'];?>"/>
                <br>

                <label for="opis">Opis:</label>
                <input name="opis" type="text" value="<?php echo $rezultat_ispis['opis'];?>"/>
                <br>

                <label for="radno_mjesto">Radno mjesto:</label>
                <input name="radno_mjesto" type="text" value="<?php echo $rezultat_ispis['radno_mjesto'];?>"/>
                <br>

                <input name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" type="hidden" value="30000000"/>
             
                <input name="slika" id="slika" type="file"/>
                <br>

                <input name="submit" type="submit" value="Unesi"/>
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