<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dunk Low Panda</title>
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
        <a  class="sneaky" href="Index.html"><h1>SNEAKYY</h1></a>
        <!-- Pour différents trucs en haut -->
        <div class="onglet">
            <a href="ajout_produit.html" class="lien"><p class="link">Ajout Produit</p></a>
            <a href="soon.html" class="lien"><p class="link">Bientôt Disponible</p></a>
            <a href="sneakers.html" class="lien"><p class="link">Sneakers</p></a>
            <a href="contact.html" class="lien"><p class="link">Nous contacter</p></a>

            <form>
               <input type="search" placeholder="Rechercher">
            </form>
            <p><i class="fa-sharp fa-solid fa-heart "></i></p>
            <a class="lien" href="panier.php"><p><i class="fa-sharp fa-solid fa-cart-shopping"></i></p></a>
            <a class="lien" href="connexion.php"><p><i class="fa-solid fa-user"></i></p></a>
        </div>
    </nav>
    <hr>
    <!-- End nav bar -->
    <table>
        <tr>
            <td rowspan="5"><img src="Images/dunklowpanda.webp" style="width: 90%;"></td>
            <td>Dunk Low Panda</td>
        </tr>

        <tr>
            <td>100€</td>
        </tr>
    <!-- Taille -->
    <tr>
        <td><label for="size">Choissisez votre taille : </label></td>
    </tr>
        <tr>
        <form method="post">
            <td><select class="input" name="taille" id="taille">
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
                <option value="45">45</option>

            </select></td>
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
					$requet= "SELECT id_sneakers FROM Sneakers WHERE Nom ='Dunk Low Panda' and Taille = '$taille'";
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
    </table>
    <hr>
    <!-- Description -->
    <div align="left" style="padding: 20px;">
    <h3>Histoire de la Dunk Low :</h3>
    <p>La Nike Dunk Low est une chaussure de sport emblématique créée par Nike en 1985. <br>
        À l'origine conçue pour le basketball, la Dunk Low a été rapidement adoptée par les skateurs pour sa durabilité et son adhérence supérieure.<br>
        La conception de la chaussure a été réalisée par Peter Moore, le même designer qui a créé la célèbre Air Jordan 1. <br>
        La Dunk Low a été inspirée par la silhouette de la Air Jordan 1, mais avec une coupe plus basse pour offrir une plus grande liberté de mouvement.</p>
    </div>




</body>
</html>