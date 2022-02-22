
<header>
    <a href="o_autoru.html" target="_blank" id="o_autoru">O autoru</a>
</header>

<nav>
    <a href="index.php" id="naslov">ZNANSTVENI FORUM</a>

    <?php
    if(!isset($_SESSION["id"])) { 
        echo "<a href='prijava.php' id='prijava'>Prijava</a>";
        } else {
            echo "<a href='prijava.php?odjava=da' id='odjava'>Odjava </a>";	
        }   

        if(isset($_SESSION["id"])) {   
            echo '<a href="profil.php" id="profil">Profil</a>';
            echo '<a href="znanstvena_podrucja.php">Znanstvena područja</a>';

            if($_SESSION["tip"] == 0) {
                echo '<a href="zahtjevi.php">Popis zahtjeva</a>';
                echo '<a href="korisnici.php">Korisnici</a>';
                echo "<a href='statistika_komentara.php' id='statistika_gumb'>Statistika</a>";                       
            }                   
            
            if($_SESSION['tip'] == 0) {
                $tip = "administrator";
            } else if($_SESSION['tip'] == 1) {
                $tip = "znanstvenik";
            } else {
                $tip = "korisnik";
            }

            echo "<a id='info'>{$_SESSION['ime']} {$_SESSION['prezime']} ($tip)</a>";
        }           
    ?>    
</nav>
