<!-- Gemaakt door: Daan Rosendal. Studentennummer: 970595318 -->
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <title>Over Ons</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <?php include('header.php') ?>
    <div class="title" unselectable="on" onselectstart="return false;" onmousedown="return false;">
        <h1>OVER ONS</h1>
    </div>
    <div id="overOns">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum
        sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
        nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel,
        aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam
        dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean
        vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem
        ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque
        rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.<br><br>

        U mag een klacht indienen als u valt onder één van de onderstaande postcodes:<br><br>

        <?php 
            // code includen om de database connectie op te zetten
            include('pdo.php');
            // alle postcodes uit de database op het scherm echo'en
            $query = "SELECT postcode FROM postcode WHERE 1";
            $postcodes = $database->prepare($query);
            try {
                $postcodes->execute(array());
                $postcodes->setFetchMode(PDO::FETCH_ASSOC);
                foreach ($postcodes as $postcode){
                    echo "- <b>".$postcode["postcode"]."</b><br>";
                }
                echo "<br>";
            }
            catch (PDOException $e){
                echo "<script>alert('Er ging iets fout bij het ophalen van de postcodes uit de database');</script><br><br>";
            }
        ?>
    </div>
</body>

</html>