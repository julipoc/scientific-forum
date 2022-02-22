<?php
    session_start();

    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT * FROM zahtjev_podrucja";    
    $upit2 = "SELECT * FROM znanstveno_podrucje";

    $rezultat2 = izvrsiUpit($veza, $upit2);
    $rezultat = izvrsiUpit($veza, $upit);

    if(isset($_POST["submit"])) {
        $upit = "INSERT INTO zahtjev_podrucja (moderator_id, znanstveno_podrucje_id, zahtjev_podrucja.status) VALUES ('{$_SESSION['id']}', '{$_POST['znanstveno_podrucje']}', 2) ON DUPLICATE KEY UPDATE moderator_id='{$_SESSION['id']}', znanstveno_podrucje_id='{$_POST['znanstveno_podrucje']}'";
        
        $rezultat = izvrsiUpit($veza, $upit);          
        header("Location: profil.php");     
    }

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

        <section id="promjena_podrucja">
            <h1>ZAHTJEV ZA ZNANSTVENO PODRUČJE</h1>
            <form name="zahtjev_form" method="post" action="promjena_znanstvenog_podrucja.php">

                <label name="znanstveno_podrucje">Odaberite znanstveno područje</label><br>
                <select name="znanstveno_podrucje" id="znanstveno_podrucje">
                <?php
                    if(isset($rezultat2)) {
                        while($red = mysqli_fetch_array($rezultat2)){
                                echo "<option value='{$red['znanstveno_podrucje_id']}'>{$red['naziv']}</option>";
                        }
                    }
                ?>
                </select><br>
                <input type="submit" name="submit" value="Pošalji zahtjev">
            </form>
        </section>
    </body>  
</html>