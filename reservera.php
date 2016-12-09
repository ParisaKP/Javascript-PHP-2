<?php
session_start();
/*gör så att felmeddelande visas*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
$db = new PDO('mysql:host=localhost;dbname=scriptsprak;charset=utf8', 'root', '');

/*kollar om användaren har lån som har gått ut. Observera att användaren kan ha flera lån.*/
function checkAnvandarnamn($anvandarnamn) {
    $sql = "SELECT * FROM bestallning WHERE anvandarnamn='$anvandarnamn'";
    global $db;
    try {
        $result = $db->query($sql); 
    } catch(PDOException $ex) {
        echo "PDOException";
    }  
    if (!empty($result) && $result->rowCount() > 0) {
        $today = date("Y-m-d");
        foreach ($result as $row) {
            if ($today > $row['aterlamningdatum'])
                return false;
        }
    }
    return true;    
}
/*kollar om boken är utlånad och i så fall vad är återlämningsdatumet.
observera att boken kan vara reserverad flera gånger (flera aterlamningdatum)*/
function hamtningdatum($book_id) {
    $sql = "SELECT * FROM bestallning WHERE bok_id='$book_id'";
    global $db;
    $datum = date("Y-m-d");
    try {
        $result = $db->query($sql); 
    } catch(PDOException $ex) {
        echo "PDOException";
    } 
    if (!empty($result) && $result->rowCount() > 0) {
        foreach ($result as $row) {
            $aterlamningdatum = $row['aterlamningdatum'];
            if ($datum < $aterlamningdatum)
                $datum = $aterlamningdatum;
        }
    }  
    return $datum;    
}
?>
<!doctype html>
<html>
<head>
    <!-- min webläsare vill inte ha denna rad
    <meta charset="UTF-8">-->
    <title>Inlmning 4 / Uppgift 1 </title>    
</head>
<body>
<?php      
    header("Content-Type: text/html; charset=UTF-8");
    if (isset($_POST['submitReserv'])) {
        $anvandarnamn = $_SESSION['anvandarnamn'];
        if (!checkAnvandarnamn($anvandarnamn))
            echo "Du har lån som har gått ut. Återlämna först lånade böckerna.";   
        else if (!isset($_POST['bok']))
            echo "välj en bok för att reservera";
        else {
            $bokTitel = $_POST['bok'];
            
            /*have to remove the white spaces in the beginning and end of the bokTitel*/
            $bokTitel = trim($bokTitel);
            $sql = "SELECT * FROM books WHERE titel='$bokTitel'";
            try {
                $result = $db->query($sql); 
            } catch(PDOException $ex) {
                echo "PDOException";
            }
            $row = $result->FETCH(PDO::FETCH_ASSOC);
            $book_id = $row['book_id'];
            
            $sql = "SELECT * FROM anvandare WHERE anvandarnamn='$anvandarnamn'";
            try {
                $result = $db->query($sql); 
            } catch(PDOException $ex) {
                echo "PDOException";
            }
            $row = $result->FETCH(PDO::FETCH_ASSOC);
            $namn = $row['namn'];
            $efternamn = $row['efternamn'];
            $telnr = $row['telnr'];
            $adress = $row['adress'];
            
            /*hämta hämtningsdatum. Om boken inte är utlånad blir det dagens datum, annars
            är det bokens återlämningsdatum om den är utlånad.*/
            $hamtningdatum = hamtningdatum($book_id);
            $aterlamningdatum = date('Y-m-d', strtotime($hamtningdatum. ' + 15 days'));       
 ?>         
            <form name="frm" method="POST" action="bekrafta.php">
                <table>
                   <tr><td><input type="hidden" name="book_id" value="<?php echo $book_id; ?> "></td></tr> 
                    <tr><td> <b>Namn:</b> <?php echo " " . $namn ?><input type="hidden" name="namn" value="<?php echo $namn; ?> "></td></tr>
                    <tr><td> <b>Efternamn: </b><?php echo " " . $efternamn ?><input type="hidden" name="efternamn" value="<?php echo $efternamn; ?> "></td></tr>
                    <tr><td> <b>Adress: </b><?php echo " " . $adress ?></td></tr>
                    <tr><td> <b>Telnr:</b><?php  echo " " . $telnr?></td></tr>
                    <tr><td> <b>Användarnamn:</b><?php  echo " " . $anvandarnamn?><input type="hidden" name="anvandarnamn" value="<?php echo $anvandarnamn; ?> "></td></tr>
                    <tr><td> <b>Boktitel: </b><?php echo " " . $bokTitel;  ?><input type="hidden" name="bokTitel" value="<?php echo $bokTitel; ?> "></td></tr>
                    <tr><td> <b>Hämtningsdatum:</b><?php echo " " . $hamtningdatum; ?><input type="hidden" name="hamtningdatum" value="<?php echo $hamtningdatum; ?> "></td></tr>
                    <tr><td> <b>Återlämningsdatum:</b> <?php echo " " . $aterlamningdatum; ?><input type="hidden" name="aterlamningdatum" value="<?php echo $aterlamningdatum; ?> "></td></tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td><input type="submit" name="submitBekrafta" value="bekräfta"></td>
                        <td><input type="submit" name="submitAvbryta" value="Avbryta" onclick="history.go(-1);"></td>
                    </tr>               
                </table>
            </form>         
<?php
        }
    } 
?>
</body>
</html>