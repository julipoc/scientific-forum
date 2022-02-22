<?php
    session_start();
    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();
    $id_korisnika = $_GET["id"];
    
    if(isset($_POST["azuriraj"])) { 
        if(isset($_POST['znan_pod'])) {
            $upit = "UPDATE korisnik SET ime='{$_POST['ime']}', prezime='{$_POST['prezime']}', titula='{$_POST['titula']}', radno_mjesto='{$_POST['radno_mjesto']}', opis='{$_POST['opis']}', email='{$_POST['email']}', korime='{$_POST['korime']}', znanstveno_podrucje_id='{$_POST['znan_pod']}', tip_korisnika_id='{$_POST['tip_id']}' WHERE korisnik_id='{$id_korisnika}'";
        } else {
            $upit = "UPDATE korisnik SET ime='{$_POST['ime']}', prezime='{$_POST['prezime']}', titula='{$_POST['titula']}', radno_mjesto='{$_POST['radno_mjesto']}', opis='{$_POST['opis']}', email='{$_POST['email']}', korime='{$_POST['korime']}', tip_korisnika_id='{$_POST['tip_id']}' WHERE korisnik_id='{$id_korisnika}'";
           
        }
        $rezultat = izvrsiUpit($veza, $upit);
        header("Location: korisnici.php");               
    }

    $upit = "SELECT * FROM korisnik WHERE korisnik_id='{$id_korisnika}'";
    $rezultat = izvrsiUpit($veza, $upit);
    $rezultat_ispis = mysqli_fetch_assoc($rezultat);

    $upit = "SELECT * FROM tip_korisnika";
    $rezultat_tipovi = izvrsiUpit($veza, $upit);

    $upit = "SELECT * FROM znanstveno_podrucje";
    $rezultat_podrucja = izvrsiUpit($veza, $upit);

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

        <section id="azuriranje_korisnika">
            <h1>AŽURIRAJ KORISNIKA</h1>
            <form name="obrazac_azuriranje_korisnika" method="post" 
            action="<?php echo $_SERVER["PHP_SELF"]."?id={$id_korisnika}"; ?> enctype="multipart/form-data">

                <label for="ime">Ime:</label>
                <input name="ime" type="text" value="<?php echo $rezultat_ispis['ime'];?>"/>
                <br>

                <label for="prezime">Prezime:</label>
                <input name="prezime" type="text" value="<?php echo $rezultat_ispis['prezime'];?>"/>
                <br>

                <label for="korime">Korisničko ime:</label>
                <input name="korime" type="text" value="<?php echo $rezultat_ispis['korime'];?>"/>
                <br>

                <label for="email">Email:</label>
                <input name="email" type="email" value="<?php echo $rezultat_ispis['email'];?>"/>
                <br>

                <label for="titula">Titula:</label>
                <input name="titula" type="text" value="<?php echo $rezultat_ispis['titula'];?>"/>
                <br>

                <label for="radno_mjesto">Radno mjesto:</label>
                <input name="radno_mjesto" type="text" value="<?php echo $rezultat_ispis['radno_mjesto'];?>"/>
                <br>

                <label for="opis">Opis:</label>
                <input name="opis" type="text" value="<?php echo $rezultat_ispis['opis'];?>"/>
                <br>

                <?php
                    if($rezultat_ispis['tip_korisnika_id'] != 2) {
                        echo '<label for="znan_pod">Znanstveno područje:</label>';
                        echo '<select name="znan_pod">';
                                while($red = mysqli_fetch_array($rezultat_podrucja)){
                                    echo "<option value='{$red['znanstveno_podrucje_id']}'";
        
                                    if($rezultat_ispis["znanstveno_podrucje_id"] == $red["znanstveno_podrucje_id"]){
                                        echo " selected='selected' ";
                                    }
                                   
                                    echo ">{$red['naziv']}</option>";
                                
                                }
                        echo '</select>
                        <br>';
                    }
                ?>
                
                <label for="tip_id">Tip:</label>
                    <select name="tip_id">
                        <?php
                            while($red = mysqli_fetch_array($rezultat_tipovi)){
                                echo "<option value='{$red['tip_korisnika_id']}'";

                                if($rezultat_ispis["tip_korisnika_id"] == $red["tip_korisnika_id"]){
                                    echo " selected='selected' ";
                                }
                                echo ">{$red['naziv']}</option>";
                            }
                        ?>
                    </select>
                    <br>

                <input name="azuriraj" type="submit" value="Ažuriraj"/>
            </form>
        </section>
    </body> 
</html>