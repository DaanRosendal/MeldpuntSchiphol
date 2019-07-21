<!-- Gemaakt door: Daan Rosendal. Studentennummer: 970595318 -->
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <title>Klachtenoverzicht</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <?php include('header.php') ?>
    <div class="title" unselectable="on" onselectstart="return false;" onmousedown="return false;">
        <h1>KLACHTENOVERZICHT</h1>
    </div>
    <div class="padding">
        <b>Klachtenoverzicht Meldpunt Schiphol</b><br><br>
        <b>Gerangschikt op postcode, datum & tijd</b><br>
        <?php 
            // code includen om de database connectie op te zetten
            include('pdo.php');
            // benodigde informatie voor het klachtenoverzicht uit de database halen en in een tabel echo'en
            $query = "SELECT kl.ID as 'nr', kl.postcode as 'postcode', date(kl.datum) as 'datum', 
                      time(kl.datum) as 'tijd', ks.klachtsoort as 'soort' FROM klachtsoort ks
                      JOIN klacht kl ON ks.ID = kl.ID_klachtsoort
                      JOIN gebruiker g ON kl.ID_gebruiker = g.ID
                      ORDER BY postcode, datum, tijd";
            $klachten = $database->prepare($query);
            try {
                $klachten->execute(array());
                $klachten->setFetchMode(PDO::FETCH_ASSOC);
                echo "<div class='padding'><table id='table1'>
                        <tr>
                            <th>nr</th>
                            <th>postcode</th>
                            <th>datum</th>
                            <th>tijd</th>
                            <th>soort</th>
                        </tr>";
                foreach ($klachten as $klacht){
                    echo "<tr><td>".$klacht["nr"]
                    ."</td><td>".$klacht["postcode"]
                    ."</td><td>".$klacht["datum"]
                    ."</td><td>".$klacht["tijd"]
                    ."</td><td>".$klacht["soort"]
                    ."</td></tr>";
                }
                echo "</table></div>";
            }
            catch (PDOException $e){
                echo "<script>alert('Er ging iets fout bij het ophalen van de klachten uit de database');</script><br><br>";
            }

            // de klachtaantallen per klachtsoort en het totaal aantal klachten uit de database halen en echo'en
            $telKlachtsoort = "SELECT COUNT(*) as :klachtSoort FROM klacht WHERE ID_klachtsoort = :klachtID";
            $telTotaal = "SELECT COUNT(*) as aantalTotaal FROM klacht";
            $aantalMilieu = $database->prepare($telKlachtsoort);
            $aantalGeluid = $database->prepare($telKlachtsoort);
            $aantalVeiligheid = $database->prepare($telKlachtsoort);
            $aantalTotaal = $database->prepare($telTotaal);
            try {
                $milieu = array("klachtSoort" => "aantalMilieu", "klachtID" => 1);
                $aantalMilieu->execute($milieu);
                $aantalM = $aantalMilieu->fetch(PDO::FETCH_ASSOC);
                echo "<table id='aantalTabel'><tr><td><b>Aantal milieu-gerelateerde klachten: </td><td>" . $aantalM['aantalMilieu'] . "</tr></td></b>";
                
                $geluid = array("klachtSoort" => "aantalGeluid", "klachtID" => 3);
                $aantalGeluid->execute($geluid);
                $aantalG = $aantalGeluid->fetch(PDO::FETCH_ASSOC);
                echo "<br><tr><td><b>Aantal geluid-gerelateerde klachten: </td><td>" . $aantalG['aantalGeluid'] . "</td></tr></b>";
                
                $veiligheid = array("klachtSoort" => "aantalVeiligheid", "klachtID" => 2);
                $aantalVeiligheid->execute($veiligheid);
                $aantalV = $aantalVeiligheid->fetch(PDO::FETCH_ASSOC);
                echo "<br><tr><td><b>Aantal veiligheid-gerelateerde klachten: </td><td>" . $aantalV['aantalVeiligheid'] . "</td></tr></b>";

                $aantalTotaal->execute();
                $aantalT = $aantalTotaal->fetch(PDO::FETCH_ASSOC);
                echo "<tr><td><b>Totaal aantal klachten: </td><td>" . $aantalT['aantalTotaal'] . "</tr></td></b></table>";
            } catch (PDOException $e) {
                echo "<br><br>Er kan geen verbinding met de database gemaakt worden.";
            }
            ?>
    </div>
</body>

</html>