<!-- BOULZE et GROSSMAN -->

<link rel="stylesheet" href="siteweb.css"/>
<title>Profil</title>
<nav>
    <a  class="sneaky" href="Index.html"><h1>SNEAKYY</h1></a>
</nav>

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

// Vérification de l'existence de la session email
// if (isset($_SESSION['email'])) {
//     // Si la session existe, on redirige vers la page de profil
//     //header('Location: profil.php');
//     //exit();
// }
$email = $_SESSION['email'];

// Récupération des données de l'utilisateur depuis la base de données
$sql = "SELECT id_client, Nom, Prenom, Email, Numero_tel, Adresse, Ville, Code_postal FROM Client WHERE Email='$email'";
$result = mysqli_query($idcon, $sql);
$row = mysqli_fetch_assoc($result);
$id_client = mysqli_fetch_row($result)[0];
$id_client1= $row['id_client'];
// echo $id_client1;

// Affichage des données de l'utilisateur
echo "<div class=container>";
echo "<h3 style='font-weight: bold; color: black;'>Voici vos informations de profil</h3>";
echo "Bonjour, ".$row['Prenom']." ".$row['Nom']."<br>";
echo "Votre adresse email est : ".$row['Email']."<br>";
echo "Votre numéro de téléphone est : ".$row['Numero_tel']."<br>";
echo "Votre adresse est : ".$row['Adresse']." ".$row['Code_postal']."<br>";
echo "</div>";
// Fermeture de la connexion à la base de données
//mysqli_close($idcon);
?>

<!-- Pour se déconnecter et supprimer son compte -->
<button  class='boutonform' onclick="window.location.href = 'logout.php';">Déconnexion</button>
<form method="post" action="">
    <!-- On fait un input caché pour pouvoir récupérer l'id de l'utilisateur -->
        <input type="hidden" name="id_client1" value="<?php echo $id_client1;?>">
        <button type="submit" name="supprime_compte" class="boutonauto">Supprimer mon compte</button>
</form>
<!-- POur modifier son compte -->

<!-- Method post et action dans un fichier php qui va traiter la demande -->
<form method="post" action="modification_traitement.php">
    <!-- On fait un input caché pour pouvoir récupérer l'id de l'utilisateur -->
        <input type="hidden" name="id_client1" value="<?php echo $id_client1;?>">
        <button type="button" class="boutonauto"  onclick="afficherForm()">Modifier mes informations</button>

        <!-- Cette div va permettre d'afficher et de cacher le formulaire de modif -->
        <div id="formulaire" class="container" style="display: none;">

        <!-- Insérez ici les champs que l'utilisateur doit pouvoir modifier -->
            <label for="nom" class="label">Nom :</label>
            <input type="text" id="nom" name="nom" class="input" value="<?php echo $row['Nom'] ?>" /><br>

            <label for="prenom" class="label">Prénom :</label>
            <input type="text" id="prenom" name="prenom" class="input" value="<?php echo $row['Prenom'] ?>" /><br>

            <label for="tel" class="label">Numéro de téléphone :</label>
            <input type="text" id="tel" name="tel" class="input" value="<?php echo $row['Numero_tel'] ?>" /><br>

            <label for="password" class="label">Mot de passe :</label><br>
            <input type="password" id="password" name="password" class="input" required value="<?php echo $row['Mot_de_passe'] ?>" /><br>

            <label for="adresse" class="label">Adresse :</label>
            <input type="text" id="adresse" name="adresse" class="input" value="<?php echo $row['Adresse'] ?>" /><br>

            <label for="ville" class="label">Ville :</label>
            <input type="text" id="ville" name="ville" class="input" value="<?php echo $row['Ville'] ?>" /><br>

            <label for="cp" class="label">Code Postal :</label>
            <input type="text" id="cp" name="cp" class="input" value="<?php echo $row['Code_postal'] ?>" /><br>

            <button type="submit">Enregistrer</button>
    </div>
</form>

<!-- Ce script va permettre d'afficher et de cacher le formulaire -->
<script>
    function afficherForm() {
        var x= document.getElementById("formulaire");   //on récupère le style avec la méthode getElementById
        if (x.style.display == 'none'){
            x.style.display = 'block';
        }
        else{
            x.style.display = 'none';
        }
    }
</script>
<?php


if (isset($_POST['supprime_compte'])) { //On vérifie que le bouton est cliqué
    $id_client1 = $_POST['id_client1'];   //On récupère l'id client 
    $query = "DELETE FROM commande WHERE id_client = $id_client1";   //Comme id_client est un clé étrangère dans la table commande on doit supprimer toutes les commandes asscociées
    if(mysqli_query($idcon, $query)) {
        $query1 = "DELETE FROM Favori WHERE id_client = $id_client1";   //On supprime aussi les favoris associés
        if(mysqli_query($idcon, $query1)){
            $delete = "DELETE FROM Client WHERE id_client = $id_client1";
            if(mysqli_query($idcon, $delete)) {
                // Suppression réussie, on redirige vers la page d'accueil
                session_destroy();  //Va deconnecter l'utilisateur
                header('Location:reponsecomptesupr.php');
        }else{
            // Erreur lors de la suppression du compte, on affiche un message d'erreur
            echo 'Erreur lors de la suppression du compte';}
    }else{
        // Erreur lors de la suppression des favoris, on affiche un message d'erreur
        echo 'Erreur lors de la suppression des favoris associés';}
}else{
    // Erreur lors de la suppression des commandes, on affiche un message d'erreur
    echo 'Erreur lors de la suprression des commandes associées';}
}




//Fermeture de la connexion à la BDD
mysqli_close($idcon);
?>