<!-- BOULZE et GROSSMAN -->

<link rel="stylesheet" href="siteweb.css">
<?php
    session_start();
    session_destroy();  //permet de détruire la session et donc l'email et le panier
    echo '<div class="confirmation-message">';  //message de confirmation de déconnexion
    echo '<div class="confirmation-message-content">';
    echo       '<h2>Vous êtes bien déconnecté.</h2>';
    echo        '<p>Vous allez être redirigé automatiquement vers la page principale.</p>';
    echo '</div></div>';
    header('refresh: 3 ; url=Index.html'); //redirige vers la page prinipal
    exit();
?>