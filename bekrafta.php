<?php
session_start();
/*g�r s� att felmeddelande visas*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
$db = new PDO('mysql:host=localhost;dbname=scriptsprak;charset=utf8', 'root', '');
?>
<!doctype html>
<html>
<head>
    <!-- min webl�sare vill inte ha denna rad
    <meta charset="UTF-8">-->
    <title>Inlmning 4 / Uppgift 1 </title>    
</head>
<body>
<?php  
   /*h�r registrers l�net och det kommer upp en bekr�ftelse.*/
    header("Content-Type: text/html; charset=UTF-8");
    if(isset($_POST['submitBekrafta'])) {
        $namn = $_POST['namn']; 
        $book_id = $_POST['book_id']; 
        $efternamn = $_POST['efternamn'];  
        $anvandarnamn = $_POST['anvandarnamn']; 
        $bokTitel = $_POST['bokTitel']; 
        $hamtningdatum = $_POST['hamtningdatum']; 
        $aterlamningdatum = $_POST['aterlamningdatum']; 
        
        $sql = "INSERT INTO bestallning (anvandarnamn, bok_id, hamtningdatum, aterlamningdatum) 
            VALUES ('$anvandarnamn', '$book_id', '$hamtningdatum', '$aterlamningdatum')";
        try {
            $result = $db->query($sql); 
        } catch(PDOException $ex) {
            echo "PDOException";
        }
        if (!empty($result) && $result->rowCount() > 0) {
            echo "<b>" . $bokTitel . " </b> �r nu l�nad till " . $namn . " " . $efternamn . "<br>";
            echo "H�mtningsdatum: " . $hamtningdatum . "<br>";
            echo "�terl�mningsdatum: " . $aterlamningdatum . "<br>";
        }       
    }
?>
</body>
</html>