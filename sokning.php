<?php
session_start();
/*gör så att felmeddelande visas*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
$db = new PDO('mysql:host=localhost;dbname=scriptsprak;charset=utf8', 'root', '');
?>
<!doctype html>
<html>
<head>
    <!--min webläsare vill inte ha denna rad
    <meta charset="UTF-8">-->
    <title>Inlmning 4 / Uppgift 1 </title>    
</head>
<body>
<?php  
    header("Content-Type: text/html; charset=UTF-8");
    /*om sql sökningen är inte tom, skrivs alla böckernas titlar ut med en radio-knapp bredvid.*/
    function checkAndPrintResult($result) {
        if (!empty($result) && $result->rowCount() > 0) {
?>
            <form name="frm" method="POST" action="reservera.php">
                <table>
                <tr><td><input type="submit" name="submitReserv" value="Välj och reservera"></td></tr>
<?php                
                foreach ($result as $row) { 
                    $titel = $row['titel'];
?>
                    <tr><td><input type="radio" name="bok" value="<?php echo $titel; ?>"> <?php echo $titel; ?></td></tr>
<?php
                }
?>                      
                </table>
            </form>
<?php                
                return true;
        }
        return false;
    }
    /*kan inte ha svenska tecken i databasen, så ändrar "övrigt" till "ovrigt"
     och "skönliteratur" till "skonliteratur".*/
    if(isset($_POST['submitSok'])) {
        $sokord = $_POST['sokfalt'];
        if ($sokord == "övrigt")
            $sokord = "ovrigt";
        else if ($sokord == "skönliteratur")
            $sokord = "skonliteratur";
        if ($_POST['sokning'] == "titel") {
            $sql = "SELECT * FROM books WHERE titel='$sokord'";
            try {
                $result = $db->query($sql); 
            } catch(PDOException $ex) {
                echo "PDOException";
            }
            if (!checkAndPrintResult($result)) 
                echo "Inga titlar hittad.";
        }
        else if ($_POST['sokning'] == "nyckelord") {
            $sql = "SELECT * FROM books WHERE titel LIKE '%$sokord%'";
            try {
                $result = $db->query($sql); 
            } catch(PDOException $ex) {
                echo "PDOException";
            }
            if (!checkAndPrintResult($result)) 
                echo "Inga titlar hittad.";
        }
        else if ($_POST['sokning'] == "kategori") {
        $sql = "SELECT * FROM books INNER JOIN kategori 
                ON books.kategori_id = kategori.kategori_id
                WHERE kategori.namn='$sokord'";
            try {
                $result = $db->query($sql); 
            } catch(PDOException $ex) {
                echo "PDOException";
            }
            if (!checkAndPrintResult($result)) 
                echo "Kategori inte hittad.";
        }
    }
    /*Översikt över alla böcker*/
    else if(isset($_POST['submitOversikt'])) {
        $sql = "SELECT * FROM books";
        try {
            $result = $db->query($sql); 
        } catch(PDOException $ex) {
            echo "PDOException";
        }
        if (!checkAndPrintResult($result)) 
            echo "Inga böcker funna.";
    }
?>
</body>
</html>