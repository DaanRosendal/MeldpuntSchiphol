<!-- Gemaakt door: Daan Rosendal. Studentennummer: 970595318 -->
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <title>Klacht ingediend!</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <?php include('header.php')?>
    <div class="title" unselectable="on" onselectstart="return false;" onmousedown="return false;">
        <h1>KLACHT INGEDIEND</h1>
    </div>
    <div class="container">
    <?php 
        include('pdo.php');
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
        $checkGebruiker->execute(array());
        $check = $checkGebruiker->fetch(PDO::FETCH_ASSOC);
        if($check){
            // nieuwe klacht aanmaken
            $query = "INSERT INTO klacht (ID_gebruiker, ID_klachtsoort, postcode, datum, prioriteit, afgehandeld) 
                      SELECT ID, '$klachtsoort','$postcode','$datum','$prioriteit',0 FROM gebruiker WHERE naam='$naam' 
                      AND postcode='$postcode' AND geslacht='$geslacht' AND geboortedatum='$geboortedatum' AND email='$email'";
            $insertKlacht = $database->prepare($query);
            $insertKlacht->execute();
            echo "Welkom terug, <b>"."$naam"."</b>! Uw klacht is ingediend en verwerkt in <a class='linkje' href='klachten.php'>ons klachtenoverzicht</a>.";
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
            echo "Bedankt, <b>"."$naam"."</b>! Uw klacht is ingediend en verwerkt in <a class='linkje' href='klachten.php'>ons klachtenoverzicht</a>.";
        }
    }
    ?>
    </div>
</body>

</html>