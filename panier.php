<!DOCTYPE html>
<html>
<?php 
    // session_start();
    // $host="localhost";
    // $user="root";
    // $mdp="root";
    // $bdd="Site";
    // $idcon= mysqli_connect($host,$user,$mdp,$bdd);
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panier</title>
    <link rel="stylesheet" href="siteweb.css">
</head>
<body>
<!-- Permet d'avoir le logo en haut pour pouvoir revenir à la page principale -->
<nav class="navinscription">
        <a  class="sneaky" href="Index.html"><h1>SNEAKYY</h1></a>
    </nav>
<?php 

session_start();
$host="localhost";
$user="root";
$mdp="root";
$bdd="Site";
$idcon= mysqli_connect($host,$user,$mdp,$bdd);

echo '<div class="cart-container">
        <h2>Mon Panier</h2>
        <ul class="cart-items">';
//on récupere l'id de la sneakers
if(!isset($_SESSION['tableau'])) {
    $_SESSION['tableau'] = array();
    echo 'Votre Panier est vide';
} 
    $info=$_SESSION['tableau'];
    //print_r($info);
    $prix=0;
    $liste=array();
    $liste2=array();
    for($i=0;$i< count($info) ;$i++){ 
        $select="SELECT Nom, Prix, Taille, Photo FROM Sneakers WHERE id_sneakers ='$info[$i]'";
        $result = mysqli_query($idcon, $select);
        //$sql=mysqli_fetch_row($result);
        
        while ($row = mysqli_fetch_assoc($result)) {
            //Addition des prix
            $prix = $prix + $row['Prix'];
            $_SESSION['prix_total'] = $prix;
            //echo $row['Nom'].' ' . $row['Taille'] . ' ' . $row['Prix'] . ' ' .$row['Stock'] .'<br>';
            echo '<li class="cart-item">
                    <div>
                        <img src="' . $row['Photo'] . '" alt="' . $row['Nom'] . '">
                        <div class="name">' . $row['Nom'].'</div>
                        <div class="price">'. $row['Prix'].'€</div>
                        <div class="size">'. $row['Taille'].'</div>
                    </div>
                    <form method="post" action="supprimer_panier.php">
                                <input type="hidden" name="item_id" value="'.$info[$i].'">
                                <button type="submit" class="remove-button">Supprimer</button>
                    </form>
                </li>';
        }
        echo '</ul>';
        //permet de faire l'addition des prix
        /*$prix=$prix+$sql[0];
            array_push($liste, $sql[1]);
            array_push($liste2, $sql[2]);*/
}



//On affiche tous les produits

echo '<div class="cart-total">Total: '.$prix.'€</div>';

//print_r($liste);

echo "<br>";
//print_r($liste2);


?>
<form method="post" action='validation_commande.php'>
  <button type="submit" name="submit" class='boutonauto'>Valider la commande</button>
</form>
</body>
</html>