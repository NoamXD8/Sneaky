<!-- BOULZE et GROSSMAN -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reponse Auto</title>
    <link rel="stylesheet" href="siteweb.css" />

</head>
<body>
    <div class="confirmation-message">
        <div class="confirmation-message-content">
        <h2>Votre compte à été supprimé avec succès...</h2>
        <p>Revenez vite vous ré-inscrire</p>
        <p>Vous aller être redirigé vers la page principale</p>
    </div></div>
    <?php 
        header('refresh: 10 ; url=index.html');
    ?>
</body>
</html>