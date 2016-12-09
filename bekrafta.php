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
    <!-- min webläsare vill inte ha denna rad
    <meta charset="UTF-8">-->
    <title>Inlmning 4 / Uppgift 1 </title>    
</head>
<body>
<?php  
   /*här registrers lånet och det kommer upp en bekräftelse.*/
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
            echo "<b>" . $bokTitel . " </b> är nu lånad till " . $namn . " " . $efternamn . "<br>";
            echo "Hämtningsdatum: " . $hamtningdatum . "<br>";
            echo "Återlämningsdatum: " . $aterlamningdatum . "<br>";
        }       
    }
?>
</body>
</html>