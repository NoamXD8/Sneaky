<?php
session_start();
$item_id = $_POST['item_id'];
// Chercher la clé du produit dans le tableau de session
$key = array_search($item_id, $_SESSION['tableau']);
// Supprimer le produit du tableau de session
if($key !== false) {
    unset($_SESSION['tableau'][$key]);
}
// Rediriger l'utilisateur vers la page du panier
header('Location: panier.php');
exit();

?>