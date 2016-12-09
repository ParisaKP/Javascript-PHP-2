<?php
session_start();
/*g�r s� att felmeddelande visas*/
error_reporting(E_ALL);
ini_set("display_errors", 1);
$db = new PDO('mysql:host=localhost;dbname=scriptsprak;charset=utf8', 'root', '');
/*Logga in med anv�ndarnamn*/
if (isset($_POST['loggin'])) {
    $anvandarnamn = $_POST['anvandarnamn'];
    $found = false;
    $sql = "SELECT * FROM anvandare WHERE anvandarnamn='$anvandarnamn'";
?>        
<!doctype html>
<html>
<head>
    <!-- min webl�sare vill inte ha denna rad
    <meta charset="UTF-8">-->
    <!--H�r kommer man f�r att s�ka i bibliotket eller registrera sig som ny anv�ndare.-->
    <title>Inl�mning 4/ uppgift 1</title>
<script>
    <!--
        /*Kollar att s�kf�lten inte �r tom*/
        function checkFields() {
            if (document.frm.sokfalt.value == "") {
                alert('S�kord saknas') 
                return false;
            }
            return true;    
        }
    -->
    </script>
    <noscript>
        Din webl�sare kan inte hantera script
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
            echo "Inte registrerad anv�ndare."?> <a href="inloggning.html">Registrera dig h�r</a> <?php ;
        }
        else {
            /*sparar anv�ndarnamnet till senare f�r att reservera*/
            $_SESSION['anvandarnamn']=$anvandarnamn;
 ?>
            <!--om man clickar p� s�k, m�ste man ha fylld i s�kf�lten, men om man klickar p�
            �versikt beh�ver man inte det.-->
            <form name="frm" method="POST" action="sokning.php">
                <table>
                    <tr>
                        <td><input type="text" size="80" name="sokfalt"></td>
                        <td><input type="submit" name="submitSok" onClick="return checkFields();" value="S�k"></td>
                    </tr>
                    <tr><td><input type="radio" name="sokning" value="titel" checked>Titel</td></tr>
                    <tr><td><input type="radio" name="sokning" value="nyckelord">Nyckelord</td></tr>
                    <tr><td><input type="radio" name="sokning" value="kategori">Kategori</td></tr>
                    <tr><td><br></td></tr>
                    <tr><td><input type="submit" name="submitOversikt" value="�versikt �ver alla b�cker"></td></tr>          
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
        /*kollar att anvandarnamnet inte finns redan.'LIMIT 1' m�ste finns. Utan det 
        funkar inte (anv�ndaren finns redan, f�s hela tiden)*/
        $sql = "INSERT INTO anvandare 
                SELECT '$namn', '$efternamn', '$adress', '$telnr', '$anvandarnamn'
                FROM anvandare
                WHERE NOT EXISTS (
                SELECT * FROM anvandare
                WHERE anvandarnamn='$anvandarnamn') LIMIT 1";
        try {
            $result = $db->query($sql); 
        if (!empty($result) && $result->rowCount() > 0)
            echo "Ny anv�ndare registrerad";
        else
            echo "Anv�ndarnamn finns redan. V�lj n�got annat.";
        } catch(PDOException $ex) {
            echo "PDOException";
        }
    }
?>
</body>
</html>