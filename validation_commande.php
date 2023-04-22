<!-- BOULZE et GROSSMAN -->

<link rel="stylesheet" href="siteweb.css">
<?php

session_start();
//Connexion à la BDD
$host = 'localhost';
$user = 'root';
$mdp = 'root';
$bdd = 'Site';

$idcon = mysqli_connect($host, $user, $mdp, $bdd) ;
if(!$idcon){
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

// Récupérer l'id du membre à partir de l'email stocké dans la session
$email = $_SESSION['email'];
$select = "SELECT id_client FROM Client WHERE Email = '$email'";
$result = mysqli_query($idcon, $select);
$id_client = mysqli_fetch_row($result)[0];

// Récupérer l'id des sneakers à partir du tableau stocké dans la session
//implode() est utilisée pour fusionner toutes les valeurs du tableau en une seule chaîne de caractères, en utilisant une virgule comme séparateur.
$id_sneakers = implode(',', $_SESSION['tableau']);

// Calculer le prix total du panier
$prix_total = $_SESSION['prix_total'];

// Définir l'état de la commande
$etat = 'en préparation';

// Insérer la commande dans la table de commandes
$insert = "INSERT INTO Commande (id_commande, id_client , id_sneakers , Prix, Date, Etat) VALUES (\N, '$id_client', '$id_sneakers',  '$prix_total', NOW(),'$etat')";
//IF qui permet de vérifier que la requete à bien été éxécutée
if(mysqli_query($idcon, $insert)){
    $id_commande = mysqli_insert_id($idcon); // Récupérer l'ID de la commande insérée
    $update_stock= "UPDATE Sneakers SET Stock = Stock - 1 WHERE id_sneakers IN ($id_sneakers) AND Stock > 0"; //Mis a jour du stock et on vérifie que le stock est supérieur à 0
    //IF qui permet de vérifier que le stock à bien été diminué
    if(mysqli_query($idcon, $update_stock)){
        echo '<div class="confirmation-message"> Mise à jour du stock des sneakers...</div>';
        unset($_SESSION['tableau']);    //On vide le panier après l'achat
        echo '<div class="confirmation-message">';  //Message de confirmation de la commande
        echo '<div class="confirmation-message-content">';
        echo       "<h2>Merci d'avoir passé commande</h2>";
        echo "<p>Votre numéro de commande est le suivant : ". $id_commande . "</p>"; // Afficher le numéro de commande
        echo        '<p>Vous allez être redirigé automatiquement vers la page index.</p>';
        echo '</div></div>';
        header('refresh: 10 ; url=Index.html'); 
    }
    else{
    echo '<div class="unconfirmation-message">Il y a eu un problème de stock</div>';}
}
else{
    echo '<div class="unconfirmation-message">Erreur dans le traitement de votre demande</div>'. mysqli_error($idcon);}


?>
