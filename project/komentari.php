<?php
    session_start();
    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();

    $upit = "SELECT kom.*, kor.ime, kor.prezime FROM korisnik kor, komentar kom WHERE kom.korisnik_id=kor.korisnik_id";
    $rezultat = izvrsiUpit($veza, $upit);      

    $upit2 = "SELECT * FROM korisnik WHERE tip_korisnika_id = 1 OR tip_korisnika_id = 0 ORDER BY prezime, ime";
    $rezultat2 = izvrsiUpit($veza, $upit2);

    zatvoriVezuNaBazu($veza);
?>

<!DOCTYPE html>
<html>
    <head>
		<title>Znanstveni forum</title>
		<meta charset="utf-8">
		<meta name="autor" content="Julija Počekal">
		<meta name="datum" content="09.12.2021.">
		<link href="stil.css" rel="stylesheet" type="text/css">
 	</head>
    <body>

        <?php
            include_once "navigacija.php";    
        ?>

        <?php 
            echo "<h1 id='komentari_naslov'>KOMENTARI PODRUČJA: {$_GET['naziv']}</h1>";   
        ?>

        <section id="komentari_section">                             
            <form id="filter_form" name="filter_form" method="post" 
            action="filtrirani_komentari.php">
                <a id="dodaj_kom2" href="dodaj_komentar.php">Dodaj komentar</a><br><br>

                <label name="filter_znanstvenika">Filtriraj: </label>
                <select name="filter_znanstvenika" id="filter_znanstvenika">
                <?php
                if(isset($rezultat2)) {
                    echo "<option value=''></option>";
                    while($red = mysqli_fetch_array($rezultat2)){
                            echo "<option value='{$red['korisnik_id']}'>{$red['ime']} {$red['prezime']}</option>";
                    }
                    
                }
                ?>
                </select>
                <input type="hidden" name="hidden_name" value="<?php echo $_GET['naziv']; ?>">
                <input type="hidden" name="hidden_id" value="<?php echo $_GET['id']; ?>">
                <input name="odDatuma" placeholder="od datuma (dd.mm.gggg.)"> -
                <input name="doDatuma" placeholder="do datuma (dd.mm.gggg.)">
                <input type="submit" value="Filtriraj" name="filtriraj">
            </form>

            <table border="1">
                <thead>
                    <tr>
                        <th>Znanstvenik</th>
                        <th>Datum</th>
                        <th>Komentar</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                    if(isset($rezultat)) {
                        while($red = mysqli_fetch_array($rezultat)){
                            if($red["znanstveno_podrucje_id"] == $_GET["id"]) {
                                $datum = strtotime($red['datum_vrijeme_kreiranja']);
                                $dt = date("d.m.Y H:i:s", $datum);                        
                                echo "<tr>";                           
                                if($red['komentar_znanstvenika'] == 1) {
                                    echo "<td><a href='znanstvenici.php?id={$red['znanstveno_podrucje_id']}&kor_id={$red['korisnik_id']}'>{$red['ime']} {$red['prezime']}</td>";
                                } else {
                                    echo "<td>{$red['ime']} {$red['prezime']}</td>";
                                }
                                echo "<td>{$dt}</td>";
                                echo "<td>{$red['sadrzaj']}</td>"; 
                                echo "</tr>";
                            }
                        }
                    }   
                ?>
                </tbody>
            </table>
        </section>
    </body>  
</html>