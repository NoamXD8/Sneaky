<!-- BOULZE et GROSSMAN -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="siteweb.css">
</head>
<body>
    <nav>
    <a  class="sneaky" href="index.html"><h1>SNEAKYY</h1></a>
    </nav>

    <?php 
    //Si l'utilisateur est connecté on le dirige vers la page profil, sinon il se connecte
    session_start();

    if (isset($_SESSION['email'])) {
        // Si la session existe, on redirige vers la page de profil
        header('Location: profil.php');
        exit();
    }
    ?>

    <!-- Container -->
    <div class="container">
        <h2>Connexion</h2>
        <!-- Formulaire de connexion -->
        <form action="connexion_traitement.php" method="POST" name="connexion">
        <!-- Adresse Mail -->
            <label class="label" for="email">Adresse Mail : </label><br>
            <input type="email" id="email" name="email" class="input" placeholder="Entrez votre email" required><br>

        <!-- Mot de passe -->
            <label class="label" for="password">Mot de passe :</label><br>
            <input type="password" id="password" name="password" class="input" placeholder="Saissiez votre mot de passe" required><br>

        <!-- Bouton -->
            <button class="boutonform" type="submit" value="login">Connexion</button><br>

        <!-- Lien pour s'inscrire -->
            <p class="label">Vous n'êtes pas encore inscrit ?  <a href="inscription.html">S'inscrire</p>
        </form>
    </div>

</body>
</html>