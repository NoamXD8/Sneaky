<!-- kcBOULZE et GROSSMAN -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panier</title>
    <link rel="stylesheet" href="siteweb.css">
</head>
<body>
<!-- Permet d'avoir le logo en haut pour pouvoir revenir à la page principale -->
<nav class="navinscription">
    <a  class="sneaky" href="index.html"><h1>SNEAKYY</h1></a>
</nav>
<?php 
//Lancement de session et connexion à la BDD
session_start();
$host="localhost";
$user="root";
$mdp="root";
$bdd="Site";
$idcon= mysqli_connect($host,$user,$mdp,$bdd);

//On définit une div pour le style du panier
echo '<div class="cart-container">
        <h2>Mon Panier</h2>
        <ul class="cart-items">';
//on récupere l'id de la sneakers
if(!isset($_SESSION['tableau'])) {  //Si le tableau est vide on affiche le panier est vide
    $_SESSION['tableau'] = array();
    echo 'Votre Panier est vide';
} 
    $info=$_SESSION['tableau']; //Les id_sneakers sont stockées dans la variable $info qui est une session
    $prix=0;        //On initialise la variable prix
    for($i=0; $i< count($info) ;$i++){ //On parcourt le variable info tant que i< count(info)
        //Donc on parcout pour chaque élément dans info
        $select="SELECT Nom, Prix, Taille, Photo FROM Sneakers WHERE id_sneakers ='$info[$i]'";
        //Requete SQL pour selectionner les caractéristiques de la sneakers
        $result = mysqli_query($idcon, $select);
        while ($row = mysqli_fetch_assoc($result)) {
            //$row va permettre d'afficher les données de la sneakers avec $row['données quon veut']
            //Addition des prix
            $prix = $prix + $row['Prix'];
            $_SESSION['prix_total'] = $prix;
            //Affichage des details
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
}



//On affiche le total des prix
echo '<div class="cart-total">Total: '.$prix.'€</div>';

echo "<br>";

?>
<!-- Bouton qui permet de valider la commande et qui va lancer le traitement de la commande via le fichier validation_commande.php -->
<form method="post" action='validation_commande.php'>
  <button type="submit" name="submit" class='boutonauto'>Valider la commande</button>
</form>
</body>
</html>