<!-- BOULZE et GROSSMAN -->
<head>
<link rel="stylesheet" type="text/css" href="siteweb.css"/>
</head>
<body>
<?php
// Récupération des données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Connexion à la base de données
$host = 'localhost';
$user = 'root';
$mdp = 'root';
$bdd = 'Site';

$idcon = mysqli_connect($host, $user, $mdp, $bdd) ;
if(!$idcon){
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Vérification des identifiants dans la base de données
$sql = "SELECT Email, Mot_de_passe FROM Client WHERE Email='$email' AND Mot_de_passe='$password'";
$result = mysqli_query($idcon, $sql);

// Vérification du résultat de la requête
if (mysqli_num_rows($result) == 1) {
    // Si les identifiants sont valides, on démarre la session
    session_start();

    // Enregistrement de l'email dans la session
    $_SESSION['email'] = $email;

    // Affichage message de confirmation et redirection vers la page d'accueil
    echo '<div class="confirmation-message">';
    echo '<div class="confirmation-message-content">';
    echo       '<h2>Vous êtes bien connecté.</h2>';
    echo        '<p>Vous allez être redirigé automatiquement vers la page profil.</p>';
    echo '</div></div>';
    header('refresh: 4 ; url=profil.php');
} else {
    // Si les identifiants sont invalides, on affiche un message d'erreur
    echo '<div class="unconfirmation-message">';
    echo '<div class="unconfirmation-message-content">';
    echo       '<h2>Identifiant invalides.</h2>';
    echo        '<p>Vous allez être redirigé automatiquement vers la page de connexion.</p>';
    echo '</div></div>';
    header('refresh: 4 ; url=connexion.php');
}

// Fermeture de la connexion à la base de données
mysqli_close($idcon);

?>
</body>