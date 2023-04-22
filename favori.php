<!-- BOULZE et GROSSMAN -->

<link rel="stylesheet" href="siteweb.css">
<script src="https://kit.fontawesome.com/5d94f6b61f.js" crossorigin="anonymous"></script>
<title>Favori</title>
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

            <form method="GET" action="search_traitement.php">
               <input type="search" name="search" placeholder="Rechercher">
            </form>
            <a class="lien" href="favori.php"><p><i class="fa-sharp fa-solid fa-heart "></i></p></a>
            <a class="lien" href="panier.php"><p><i class="fa-sharp fa-solid fa-cart-shopping"></i></p></a>
            <a class="lien" href="connexion.php"><p><i class="fa-solid fa-user"></i></p></a>
        </div>
    </nav>
    <!-- End nav bar -->
</body>

<?php
//Connexion à la BDD
session_start();
$host = 'localhost';
$user = 'root';
$mdp = 'root';
$bdd = 'Site';

$idcon = mysqli_connect($host, $user, $mdp, $bdd) ;
if(!$idcon){
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Récupérer l'id du membre à partir de l'email stocké dans la session
$email = $_SESSION['email'];
$select = "SELECT id_client FROM Client WHERE Email = '$email'";
$result = mysqli_query($idcon, $select);
$id_client = mysqli_fetch_row($result)[0];

// Récupérer les favoris du client en faisant un JOIN entre les 2 tables Sneakers et Favori
$query = "SELECT Sneakers.Nom, Sneakers.Photo, Sneakers.Taille, Sneakers.id_sneakers, Sneakers.Lien FROM Favori INNER JOIN Sneakers ON Favori.id_sneakers = Sneakers.id_sneakers WHERE Favori.id_client = $id_client";
$result1 = mysqli_query($idcon, $query);

// Afficher les favoris
echo '<div class="favori-container">';
echo '<h2>Mes Favoris</h2>';
//On définit des listes
echo '<ul class="favori-list">';
//On va ajouter une liste pour chaque sneakers en favori
while ($row = mysqli_fetch_assoc($result1)) {
// On récupère chaque ligne des résultats de la requête SQL et on l'affiche à travers une boucle "while"
    echo '<li class="favori-item">
        <a href="' . $row['Lien'] . '"><img src="' . $row['Photo'] . '" alt="' . $row['Nom'] . '"></a>            
            <div>' . $row['Nom'].'</div>
            <div>'. $row['Taille'].'</div>
            <form method="post" action="">
                    <input type="hidden" name="id_sneakers" value="'. $row['id_sneakers'] .'">
                    <button type="submit" name="add_to_cart">Ajouter au Panier</button>
                    <button type="submit" name="supprime_favori">Supprimer des favoris</button>
            </form>
        </li>';
}
echo '</ul>';
echo '</div>';

if(isset($_POST['supprime_favori'])){
    $id_sneakers = $_POST['id_sneakers'];
    $sql = "DELETE FROM Favori WHERE id_client = $id_client AND id_sneakers = $id_sneakers";
    $delet = mysqli_query($idcon, $sql);
    header('Location: favori.php');
}

if(isset($_POST['add_to_cart'])){
    
}

?>