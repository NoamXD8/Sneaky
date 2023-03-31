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

// Vérifier si le panier est vide
if(empty($_SESSION['tableau'])) {
    header('Location: panier.php');
    exit;
}

// Récupérer l'id du membre à partir de l'email stocké dans la session
$email = $_SESSION['email'];
$select = "SELECT id_client FROM Client WHERE Email = '$email'";
$result = mysqli_query($idcon, $select);
$id_client = mysqli_fetch_row($result)[0];

// Récupérer l'id des sneakers à partir du tableau stocké dans la session
$id_sneakers = implode(',', $_SESSION['tableau']);

    // Traitement à effectuer pour chaque sneaker ID
    // Par exemple : $sneaker_id peut être utilisé pour récupérer les informations de la sneaker depuis la base de données


// Calculer le prix total du panier
$prix_total = $_SESSION['prix_total'];


// Définir l'état de la commande
$etat = 'en préparation';

// Insérer la commande dans la table de commandes
$insert = "INSERT INTO Commande (id_commande, id_client , id_sneakers , Prix, Date, Etat) VALUES (\N, '$id_client', '$id_sneakers',  '$prix_total', NOW(),'$etat')";
if(mysqli_query($idcon, $insert)){
    unset($_SESSION['tableau']);
    echo '<div class="confirmation-message">';
    echo '<div class="confirmation-message-content">';
    echo       "<h2>Merci d'avoir passé commande</h2>";
    echo        '<p>Vous allez être redirigé automatiquement vers la page index.</p>';
    echo '</div></div>';
    header('refresh: 3 ; url=Index.html'); 
}
else{
    echo '<div class="unconfirmation-message">Erreur dans le traitement de votre demande</div>';
}

// Vider le panier

?>
