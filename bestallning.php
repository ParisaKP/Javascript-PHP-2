<?php
session_start();
/*gör så att felmeddelande visas*/
error_reporting(E_ALL);
ini_set("display_errors", 1);
$db = new PDO('mysql:host=localhost;dbname=scriptsprak;charset=utf8', 'root', '');
/*Logga in med användarnamn*/
if (isset($_POST['loggin'])) {
    $anvandarnamn = $_POST['anvandarnamn'];
    $found = false;
    $sql = "SELECT * FROM anvandare WHERE anvandarnamn='$anvandarnamn'";
?>        
<!doctype html>
<html>
<head>
    <!-- min webläsare vill inte ha denna rad
    <meta charset="UTF-8">-->
    <!--Här kommer man för att söka i bibliotket eller registrera sig som ny användare.-->
    <title>Inlämning 4/ uppgift 1</title>
<script>
    <!--
        /*Kollar att sökfälten inte är tom*/
        function checkFields() {
            if (document.frm.sokfalt.value == "") {
                alert('Sökord saknas') 
                return false;
            }
            return true;    
        }
    -->
    </script>
    <noscript>
        Din webläsare kan inte hantera script
    </noscript>
</head>
<body>
<?php
        try {
            $result = $db->query($sql); 
        if ($result->rowCount() > 0)
            $found = true;
        } catch(PDOException $ex) {
            echo "PDOException";
        }
        if (!$found) {
            echo "Inte registrerad användare."?> <a href="inloggning.html">Registrera dig här</a> <?php ;
        }
        else {
            /*sparar användarnamnet till senare för att reservera*/
            $_SESSION['anvandarnamn']=$anvandarnamn;
 ?>
            <!--om man clickar på sök, måste man ha fylld i sökfälten, men om man klickar på
            översikt behöver man inte det.-->
            <form name="frm" method="POST" action="sokning.php">
                <table>
                    <tr>
                        <td><input type="text" size="80" name="sokfalt"></td>
                        <td><input type="submit" name="submitSok" onClick="return checkFields();" value="Sök"></td>
                    </tr>
                    <tr><td><input type="radio" name="sokning" value="titel" checked>Titel</td></tr>
                    <tr><td><input type="radio" name="sokning" value="nyckelord">Nyckelord</td></tr>
                    <tr><td><input type="radio" name="sokning" value="kategori">Kategori</td></tr>
                    <tr><td><br></td></tr>
                    <tr><td><input type="submit" name="submitOversikt" value="Översikt över alla böcker"></td></tr>          
                </table>
            </form>
 <?php
        }
    }
    /*Registrera: check if submit button has been pressed.*/
    else if(isset($_POST['register']) && $_POST['register']=='Registrera') {
        $namn = $_POST['namn'];
        $efternamn = $_POST['efternamn'];
        $adress = $_POST['adress'];
        $telnr = $_POST['telnr'];
        $anvandarnamn = $_POST['anvandarnamn2'];
        /*kollar att anvandarnamnet inte finns redan.'LIMIT 1' måste finns. Utan det 
        funkar inte (användaren finns redan, fås hela tiden)*/
        $sql = "INSERT INTO anvandare 
                SELECT '$namn', '$efternamn', '$adress', '$telnr', '$anvandarnamn'
                FROM anvandare
                WHERE NOT EXISTS (
                SELECT * FROM anvandare
                WHERE anvandarnamn='$anvandarnamn') LIMIT 1";
        try {
            $result = $db->query($sql); 
        if (!empty($result) && $result->rowCount() > 0)
            echo "Ny användare registrerad";
        else
            echo "Användarnamn finns redan. Välj något annat.";
        } catch(PDOException $ex) {
            echo "PDOException";
        }
    }
?>
</body>
</html>