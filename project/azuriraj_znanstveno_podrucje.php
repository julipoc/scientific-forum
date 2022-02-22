<?php
    session_start();
    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();
    $id_podrucja = $_GET["id"];
    
    if(isset($_POST["azuriraj"])) { 
        $upit = "UPDATE znanstveno_podrucje SET naziv='{$_POST['naziv']}', opis='{$_POST['opis']}'  WHERE znanstveno_podrucje_id='{$id_podrucja}'";
        $rezultat = izvrsiUpit($veza, $upit);
        header("Location: znanstvena_podrucja.php");       
    }

    $upit = "SELECT * FROM znanstveno_podrucje WHERE znanstveno_podrucje_id='{$id_podrucja}'";
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

        <section id="azuriraj_podrucje">
            <h1>AŽURIRAJ PODRUČJE</h1>
            <form id="obrazac_azuriranje_podrucja" method="post" 
            action="<?php echo $_SERVER["PHP_SELF"]."?id={$id_podrucja}"; ?>" >

                <label for="naziv">Naziv:<label>
                <input name="naziv" type="text" value="<?php echo $rezultat_ispis['naziv'];?>"/>
                <br>
            
                <label for="opis">Opis:<label>
                <input name="opis" type="text" value="<?php echo $rezultat_ispis['opis'];?>"/>
                <br>

                <input name="azuriraj" type="submit" value="Ažuriraj"/>
            </form>
        </section>
    </body>  
</html>