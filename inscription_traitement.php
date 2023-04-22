<!-- BOULZE et GROSSMAN -->

<link rel="stylesheet" href="siteweb.css" />

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

    //on récupère les informations grâce à la méthode post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $tel=$_POST['tel'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $adresse= $_POST['adresse'];
        $ville=$_POST['ville'];
        $cp=$_POST['cp'];

    //Requete SQL pour vérifier si un client est déja associé à cet email
    $sql_select = "SELECT id_client FROM Client WHERE Email = '$email' LIMIT 1";
    $result = mysqli_query($idcon, $sql_select);

    //Test Pour vérifier qu'un compte existe déja 
    if (mysqli_num_rows($result) > 0) {
        // L'adresse email existe déjà, renvoyer une erreur
        echo '<div class="unconfirmation-message">';
        echo '<div class="unconfirmation-message-content">';
        echo '<h2>Une erreur est survenue lors de l\'inscription.</h2>';
        echo '<p>Un compte avec cette adresse email existe déjà.</p>';
        echo '<p>Veuillez réessayer avec une autre adresse email.</p>';
        header('refresh: 5 ; url=connexion.php'); 
        echo '</div></div>';
    }
    //Si l'adresse email n'est associé à aucun compte
    else{
    //REquete permettant d'ajouter le client à la BDD
    $sql_insert = "INSERT INTO Client (id_client, Nom, Prenom, Numero_tel, Email, Mot_de_passe, Adresse, Ville, Code_postal)
    VALUES (\N,'$nom', '$prenom', '$tel', '$email', '$password', '$adresse', '$ville', '$cp')";
        // Si la requête est exécutée avec succès
        if (mysqli_query($idcon, $sql_insert)) {
            echo '<div class="confirmation-message">';
            echo '<div class="confirmation-message-content">';
            echo       '<h2>Vous êtes bien inscrit à notre site web.</h2>';
            echo        '<a href=connexion.php><p>Cliquez ici pour vous connecter</p></a>';
            echo '</div></div>';
        } else {
            echo "Erreur : " . $sql . "<br>" . mysqli_error($idcon);
        }
    }
}
// Fermeture de la connexion à la base de données
mysqli_close($idcon);
?>