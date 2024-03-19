<!-- BOULZE et GROSSMAN -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J1 Lost and Found</title>
    <link rel="stylesheet" href="siteweb.css">
    <script src="https://kit.fontawesome.com/5d94f6b61f.js" crossorigin="anonymous"></script>
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
?>
</head>
<body>
        <!-- Bare de naviguation -->
    <nav>
        <a  class="sneaky" href="index.html"><h1>SNEAKYY</h1></a>
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
    <hr>
    <!-- End nav bar -->
    <table>
        <tr>
            <td rowspan="6"><img src="Images/aj1lostandfound.webp" style="width: 90%;"></td>
            <td>Jordan 1 Lost & Found</td>
        </tr>

        <tr>
            <td>180€</td>
        </tr>
    <!-- Taille -->
    <tr>
        <td><label for="taille">Choissisez votre taille : </label></td>
    </tr>
        <tr>
        <form method="post">
        <?php 
            $requet_stock= "SELECT Taille, Stock FROM Sneakers WHERE Nom='Jordan 1 Lost and Found'";
            $result = mysqli_query($idcon, $requet_stock); 
            echo '<td><select class="input" name="taille" id="taille">';     
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['Taille'] . '">' . $row['Taille'] . ' - Stock : ' . $row['Stock'] . '</option>';

            }
            echo '</select></td>';
            ?>

<!-- php -->
        </tr>
        
        <!-- Ajouter panier -->
        <tr><td>
            <?php
            //On vérifie que l'utilisateur est connecté
					if(isset($_SESSION['email'])){
						echo "<button class='boutonform' type='submit' value='submit'>Ajout au panier</button>";
					}
                    if(!isset($_SESSION['email'])){
						echo "<div style='text-align:center;'><span style='font-size:20px;'>Veuillez vous connecter pour ajouter un produit au panier</span></div>";
					}
					?>
					<?php
					if (isset($_POST["taille"])) {
					$taille=$_POST["taille"];

                    //On sélectionne ce quon veut dans la BDD
					$requet= "SELECT id_sneakers FROM Sneakers WHERE Nom ='Jordan 1 Lost and Found' and Taille = '$taille'";
					$result = $idcon->query($requet);
					$sql=mysqli_fetch_row($result);

                    //Cette ligne ajoute l'ID de la paire de chaussures sélectionnée à un tableau stocké dans une variable de session 
                    /*if(!isset($_SESSION['tableau'])) {
                        $_SESSION['tableau'] = array();
                    }*/
					array_push($_SESSION['tableau'], $sql[0]);
                    //header('refresh: 1 ; url= panier.php');
					}
			?>
        <td></tr>

        <!-- Ajout en Favori -->
        <tr><td>
            <form method="post">
                <input type="hidden" name="id_sneakers" value="<?php echo $id_sneakers; ?>">
                <button type="submit" class="boutonfavori" name="add_to_favorites"><i class="fa-solid fa-heart fa-2x"></i></button>
             </form>
        </td></tr>

<?php 
        if (isset($_POST['add_to_favorites'])) {
            if (isset($_POST["taille"])) {
                $taille=$_POST["taille"];
            
            //On sélectionne ce quon veut dans la BDD donc l'id sneakers
            $requet= "SELECT id_sneakers FROM Sneakers WHERE Nom ='Jordan 1 Lost and Found' and Taille = '$taille'";
            $result = mysqli_query($idcon, $requet);
            $id_sneakers=mysqli_fetch_row($result)[0];
        }

            // Récupérer l'id du membre à partir de l'email stocké dans la session
            $email = $_SESSION['email'];
            $select = "SELECT id_client FROM Client WHERE Email = '$email'";
            $result = mysqli_query($idcon, $select);
            $id_client = mysqli_fetch_row($result)[0];

            // Vérifiez si la paire de chaussures est déjà dans les favoris
            $query1 = "SELECT * FROM Favori WHERE id_sneakers = $id_sneakers AND id_client = $id_client";
            $result = mysqli_query($idcon, $query1);
            if (mysqli_num_rows($result) > 0) {
                // Si La paire de chaussures est déjà dans les favoris
                echo '<div class="confirmation-message">
                        <div class="confirmation-message-content">
                            <p>Cette paire de chaussures est déjà dans vos favoris.</p>
                    </div></div>';
            } else {
                // Si La paire de chaussures n'est pas encore dans les favoris
                //on fait une requete SQL pour insérer l'id du client et l'id de la sneakers dans la table favori
                $query2 = "INSERT INTO Favori (id_client, id_sneakers) VALUES ($id_client, $id_sneakers)";
                if(mysqli_query($idcon, $query2)){
                    echo '<div class="confirmation-message">';
                    echo '<div class="confirmation-message-content">';
                    echo        '<p>La paire de chaussures a bien été ajoutée à vos favoris.</p>';
                    echo '</div></div>';            }
                else{
                    //Si il y a une erreur avec la requete sql on affiche une erreur
                    echo '<script>alert("Erreur")</script>';
                }
            }
        }
?>
    </table>
    <hr>
    <div align="left" style="padding: 20px;">
        <h3>Histoire de la Jordan 1 :</h3>
        <p>La Air Jordan 1 est la toute première silhouette de Jordan, et la plus emblématique. <br>
            Sortie en 1985 et designé par Peter Moore, elle séduit immédiatement par son design radical et ses couleurs audacieuses. <br>
            Comptant actuellement plusieurs versions : Low, Mid et High. La AJ1 reste le modèle phare de Jordan qui ne lésine pas sur les déclinaisons.
        </p>
    </div>
    <hr>
    <div align="left" style="padding: 20px;">
        <h3>Présentation du produit :</h3>
        <p>Cette Jordan 1 Lost and Found est une inspiration direct de la <a href="https://stockx.com/fr-fr/jordan-1-og-chicago-1985" target="_blank">Jordan 1 Chicago OG</a> sortie en 1985<br>
            La Chicago est rééditée en 1994, 2013, 2015 et enfin en 2022 avec ce modèle.

        </p>

    </div>


</body>
</html>