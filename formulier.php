<!-- Gemaakt door: Daan Rosendal. Studentennummer: 970595318 -->
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <title>Klacht Indienen</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <?php include('header.php') ?>
    <div class="title" unselectable="on" onselectstart="return false;" onmousedown="return false;">
        <h1>KLACHT INDIENEN</h1>
    </div>
    <div id="container">
        <div style="color: #0033cc; cursor: context-menu;" unselectable="on" onselectstart="return false;"
            onmousedown="return false;">
            <p>Vul dit formulier in om een klacht in te dienen.</p>
            <p><b>Let op: </b> u mag alleen een klacht indienen als u valt onder één van de <a class="linkje"
                    href="about-us.php" target="_blank"><b>toegestane
                        postcodes.</b></a></p>
        </div>
        <form name="formulier" action="verwerken.php" method="post">
            <input required autocomplete="off" type="text" name="naam" placeholder="Naam">
            <br>
            <span style="color: #0033cc; cursor:context-menu;" unselectable="on" onselectstart="return false;"
                onmousedown="return false;">Geslacht</span>
            <ul class="geslacht">
                <li>
                    <input required type="radio" id="man" name="geslacht" value="M">
                    <label for="man">Man<br>
                </li>
                <li>
                    <input required type="radio" id="vrouw" name="geslacht" value="V">
                    <label for="vrouw">Vrouw<br>
                </li>
            </ul>
            <span style="color: #0033cc; cursor:context-menu;" unselectable="on" onselectstart="return false;"
                style="color: #0033cc; cursor:context-menu;" unselectable="on"
                onselectstart="return false;">Geboortedatum</span>
            <label id="
                geboortedatum">
                <br><input required autocomplete="off" type="date" name="geboortedatum">
            </label>
            <br>
            <input required autocomplete="off" type="email" name="email" placeholder="E-mail">
            <br>
            <?php 
                // alle postcodes die toegestaan zijn om een klacht in te dienen ophalen uit de database zodat de klant zijne er uit kan kiezen
                include('pdo.php');
                $query = "SELECT postcode FROM postcode WHERE 1";
                $postcodes = $database->prepare($query);
                try {
                    $postcodes->execute();
                    $postcodes->setFetchMode(PDO::FETCH_ASSOC);
                    echo "<select required name='postcode'>
                          <option value=''>Postcode</option>";
                    foreach ($postcodes as $postcode){
                        echo "<option value='".$postcode["postcode"]."'>".$postcode["postcode"]."</option>";
                    }
                    echo "</select>";
                }
                catch (PDOException $e){
                    echo "<script>alert('<b>Er ging iets fout bij het ophalen van de postcodes uit de database</b>');</script><br><br>";
                }
            ?>
            <br>
            <?php
                // klachtsoorten en bijbehorende IDs ophalen uit de database zodat de gebruiker er uit kan kiezen
                $query = "SELECT ID, klachtsoort FROM klachtsoort WHERE 1";
                $klachtsoorten = $database->prepare($query);
                try {
                    $klachtsoorten->execute();
                    $klachtsoorten->setFetchMode(PDO::FETCH_ASSOC);
                    echo "<select required name='klachtsoort'>
                          <option value=''>Klacht</option>";
                    foreach ($klachtsoorten as $klachtsoort){
                        echo "<option value='".$klachtsoort["ID"]."'>".ucfirst($klachtsoort["klachtsoort"])."</option>";
                    }
                    echo "</select>";
                }
                catch (PDOException $e){
                    echo "<script>alert('<b>Er ging iets fout bij het ophalen van de postcodes uit de database</b>');</script><br><br>";
                }
            ?>
            <br>
            <select required name="prioriteit">
                <option value="">Prioriteit</option>
                <option value="2">Laag</option>
                <option value="1">Hoog</option>
            </select>
            <br>
            <input type="submit" name="submit" value="Klacht Indienen">
            <input type="reset" name="reset" value="Reset">
        </form>
    </div>
    <div id="verwerken">
        <?php
            if (isset($_POST["submit"])){
                $naam = $_POST["naam"];
                $geslacht = $_POST["geslacht"];
                $geboortedatum = $_POST["geboortedatum"];
                $email = $_POST["email"];
                $postcode = $_POST["postcode"];
                $klachtsoort = $_POST["klachtsoort"];
                $prioriteit = $_POST["prioriteit"];
                $datum = date('Y-m-d H:i:s');
                
                // checken of dit iemand is die al eerder een klacht heeft ingediend. false = nieuwe gebruiker aanmaken
                $query = "SELECT ID FROM gebruiker WHERE naam='$naam' AND postcode='$postcode' AND geslacht='$geslacht'
                          AND geboortedatum='$geboortedatum' AND email='$email'";
                $checkGebruiker = $database->prepare($query);
                $checkGebruiker->execute();
                $check = $checkGebruiker->fetch(PDO::FETCH_ASSOC);
                if($check){
                    // nieuwe klacht aanmaken
                    $query = "INSERT INTO klacht (ID_gebruiker, ID_klachtsoort, postcode, datum, prioriteit, afgehandeld) 
                              SELECT ID, '$klachtsoort','$postcode','$datum','$prioriteit',0 FROM gebruiker WHERE naam='$naam' 
                              AND postcode='$postcode' AND geslacht='$geslacht' AND geboortedatum='$geboortedatum' AND email='$email'";
                    $insertKlacht = $database->prepare($query);
                    $insertKlacht->execute();
                    echo "Welkom terug, "."$naam"."! Uw klacht is ingediend.";
                } else {
                    // nieuwe gebruiker aanmaken
                    $query = "INSERT INTO gebruiker (naam, postcode, geslacht, geboortedatum, email) 
                              VALUES ('$naam','$postcode','$geslacht','$geboortedatum','$email')";
                    $insertGebruiker = $database->prepare($query);
                    $insertGebruiker->execute();

                    // nieuwe klacht aanmaken
                    $query = "INSERT INTO klacht (ID_gebruiker, ID_klachtsoort, postcode, datum, prioriteit, afgehandeld) 
                            SELECT ID, '$klachtsoort','$postcode','$datum','$prioriteit',0 FROM gebruiker WHERE naam='$naam' 
                            AND postcode='$postcode' AND geslacht='$geslacht' AND geboortedatum='$geboortedatum' AND email='$email'";
                    $insertKlacht = $database->prepare($query);
                    $insertKlacht->execute();
                    echo "Bedankt, "."$naam"."! Uw klacht is ingediend.";
                }
            }
        ?>
    </div>
</body>

</html>