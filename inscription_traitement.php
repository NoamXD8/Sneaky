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

    // Requête SQL pour ajouter le client à la base de données
    $sql = "INSERT INTO Client (id_client, Nom, Prenom, Numero_tel, Email, Mot_de_passe, Adresse, Ville, Code_postal)
    VALUES (\N,'$nom', '$prenom', '$tel', '$email', '$password', '$adresse', '$ville', '$cp')";

    if (mysqli_query($idcon, $sql)) {
        //echo "Le client a été ajouté avec succès à la base de données.";
        echo '<div class="confirmation-message">';
        echo '<div class="confirmation-message-content">';
        echo       '<h2>Vous êtes bien inscrit à notre site web.</h2>';
        echo        '<a href=connexion.php><p>Cliquez ici pour vous connecter</p></a>';
        echo '</div></div>';
    } else {
        echo "Erreur : " . $sql . "<br>" . mysqli_error($idcon);
    }

    // Fermeture de la connexion à la base de données
    mysqli_close($idcon);

    }

?>