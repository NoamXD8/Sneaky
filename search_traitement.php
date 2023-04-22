<!-- BOULZE et GROSSMAN -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="siteweb.css">
    <script src="https://kit.fontawesome.com/5d94f6b61f.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Bare de naviguation -->
    <nav>
        <a  class="sneaky" href="Index.html"><h1>SNEAKYY</h1></a>
        <!-- Pour différents trucs en haut -->
        <div class="onglet">
            <a href="ajout_produit.html" class="lien"><p class="link">Ajout Produit</p></a>
            <a href="soon.html" class="lien"><p class="link">Bientôt Disponible</p></a>
            <a href="sneakers.html" class="lien"><p class="link">Sneakers</p></a>
            <a href="contact.html" class="lien"><p class="link">Nous contacter</p></a>
        <!-- On récupère les recherches avec la méthode GET car pas confidentielles -->
            <form method="GET" action="search_traitement.php">
               <input type="search" name="search" placeholder="Rechercher">
            </form>
            <a class="lien" href="favori.php"><p><i class="fa-sharp fa-solid fa-heart "></i></p></a>
            <a class="lien" href="panier.php"><p><i class="fa-sharp fa-solid fa-cart-shopping"></i></p></a>
            <a class="lien" href="connexion.php"><p><i class="fa-solid fa-user"></i></p></a>
        </div>
    </nav>
    <!-- End nav bar -->
<?php
//Connexion à la BDD
$host="localhost";
$user="root";
$mdp="root";
$bdd="Site";
$idcon= mysqli_connect($host,$user,$mdp,$bdd);
if(!$idcon){
    die("La connexion a échoué : " . mysqli_connect_error());
}

$search = $_GET['search'];  //Récupération de la recherche
$sql = "SELECT DISTINCT Photo, Nom, Prix, Modèle, Marque, Lien FROM Sneakers WHERE Modèle LIKE '%$search%' OR Nom LIKE '%$search%' OR Marque LIKE '%$search%'";
//DISTINCT permet de faire apparaitre une seule fois chaque paire
$result = mysqli_query($idcon, $sql);

//On vérifie si il y a un résultat avec la méthode num_rows qui est égale au nombre de ligne renvoyé par le result.
if(mysqli_num_rows($result) == 0) {
    // si  == 0 alors cela veut dire qu'il n'y a pas de résultats
    echo '<div class="principale"><p>Pas de résultats correspondant à votre recherche.</p></div>';
} else {
    //sinon on affiche tous les détails des résultats de la requete avec $row
    echo  '<div class="principale"><div class="carts">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="cart">
            <a href="' . $row['Lien'] . '"><img src="' . $row['Photo'] . '" alt="' . $row['Nom'] . '"></a>
                
                <div class="cart-header">
                    <h4 class="title">' .$row["Nom"]. '</h4>
                    <h4 class="prix">'. $row["Prix"].'€</h4></div>';
        echo '</div>';
    }
    echo '</div></div>';
}

?>
<!--Ligne 58 : Lien caché derrière l'image, le lien est stocké dans la BDD -->

</body>