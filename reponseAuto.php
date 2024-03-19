<!-- BOULZE et GROSSMAN -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reponse Auto</title>
    <link rel="stylesheet" href="siteweb.css" />
</head>
<body>
    <a href="index.html" class='lien'><button class='boutonauto' type="submit">Retour à la page principale</a>
    <?php 
    //Connexion à la BDD
    $host = 'localhost';
    $user = 'root';
    $mdp = 'root';
    $bdd = 'Site';
    
    $idcon = mysqli_connect($host, $user, $mdp, $bdd) ;
    if(!$idcon){
        die("La connexion a échoué : " . mysqli_connect_error());
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom= $_POST['name'];
        $email= $_POST['email'];
        $objet = $_POST['objet'];
        $n_commande = $_POST['n_commande'];
        $commentaire = $_POST['commentaire'];
    
    $sql = "INSERT INTO Contact (Nom, Email, Objet, Num_commande, Commentaire) VALUES ('$nom', '$email', '$objet', '$n_commande', '$commentaire')";
    

    if (mysqli_query($idcon, $sql)) {
        echo '<div class="confirmation-message">
        <div class="confirmation-message-content">
        <p>Merci de nous avoir contacter notre service vous adressera une réponse dans les meilleurs délai.</p><br>
        <p>Vous aller être redirigé vers la page principale ou cliquer sur le bouton ci dessous</p>
    </div></div>';
    }


    //redirection sur la page principale
        header('refresh: 6 ; url=Index.html');
}
    ?>
</body>
</html>