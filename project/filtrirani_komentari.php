<?php
    session_start();
    include_once("baza_funkcije.php");
    $veza = spojiSeNaBazu();
  

    if ($_POST['odDatuma']) {
        $odDatuma = date('Y-m-d H:i:s', strtotime($_POST['odDatuma']));
    } else {
        $odDatuma = date('Y-m-d H:i:s', strtotime('1.1.1970'));
    }

    if ($_POST['doDatuma']) {
        $doDatuma = date('Y-m-d H:i:s', strtotime($_POST['doDatuma']));
    } else {
        $doDatuma = date('Y-m-d H:i:s');
    }


    if (!isset($_POST["filter_znanstvenika"]) || $_POST["filter_znanstvenika"] == "") {
        $upit_filter_1 = "SELECT kom.*, kor.ime, kor.prezime FROM korisnik kor, komentar kom WHERE kom.korisnik_id=kor.korisnik_id AND kom.datum_vrijeme_kreiranja BETWEEN '$odDatuma' AND '$doDatuma'";
        $rezultat_filter_1 = izvrsiUpit($veza, $upit_filter_1);

    } else {
        $upit_filter_2 = "SELECT * FROM komentar WHERE korisnik_id='{$_POST['filter_znanstvenika']}' AND znanstveno_podrucje_id='{$_POST['hidden_id']}' AND datum_vrijeme_kreiranja BETWEEN '$odDatuma' AND '$doDatuma'";
        $rezultat_filter_2 = izvrsiUpit($veza, $upit_filter_2);

        $upit_ime = "SELECT ime, prezime FROM korisnik WHERE korisnik_id='{$_POST['filter_znanstvenika']}'";
        $rezultat_ime = izvrsiUpit($veza, $upit_ime);
        $rezultat_ime = mysqli_fetch_assoc($rezultat_ime);
    }
    
      
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
            if(isset($rezultat_filter_1)) {
                echo "<h1 id='filter_naslov'>KOMENTARI U TRAŽENOM VREMENSKOM RAZDOBLJU ({$_POST['hidden_name']})</h1>";
            } else {
                echo "<h1 id='filter_naslov'>KOMENTARI ZNANSTVENIKA: {$rezultat_ime['ime']} {$rezultat_ime['prezime']} ({$_POST['hidden_name']})</h1>";
            }
          
        ?>

        <section id="filter_section">                             
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
                if(isset($rezultat_filter_1)) {
                    while($red = mysqli_fetch_array($rezultat_filter_1)){
                        if($red["znanstveno_podrucje_id"] == $_POST["hidden_id"]) {
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
                } else if(isset($rezultat_filter_2)) {
                    while($red = mysqli_fetch_array($rezultat_filter_2)){
                        if($red["znanstveno_podrucje_id"] == $_POST["hidden_id"]) {
                            $datum = strtotime($red['datum_vrijeme_kreiranja']);
                            $dt = date("d.m.Y H:i:s", $datum);                        
                            echo "<tr>";                           
                            if($red['komentar_znanstvenika'] == 1) {
                                echo "<td><a href='znanstvenici.php?id={$red['znanstveno_podrucje_id']}&kor_id={$red['korisnik_id']}'>{$rezultat_ime['ime']} {$rezultat_ime['prezime']}</td>";
                            } else {
                                echo "<td>{$rezultat_ime['ime']} {$rezultat_ime['prezime']}</td>";
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