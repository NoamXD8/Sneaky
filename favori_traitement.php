<?php
// Connexion à la base de données
$host = "localhost";
$user = "root";
$mdp = "root";
$bdd = "Site";
$idcon = mysqli_connect($host, $user, $mdp, $bdd);
if (!$idcon) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Récupération de l'identifiant de la sneaker à ajouter en favori et de l'identifiant du membre
$id_sneakers = $_POST['id_sneakers'];
$id_client = $_SESSION['email'];

// Insertion de la sneaker en favori dans la base de données
$sql = "INSERT INTO Favori (id_client, id_sneakers) VALUES ('$id_client', '$id_sneakers')";
if(mysqli_query($idcon, $sql)){
    echo 'Produit ajouté aux favoris';
}
else{
    echo 'Erreur';
}

// Fermeture de la connexion à la base de données
mysqli_close($idcon);
?>