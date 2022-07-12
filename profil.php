<?php
session_start();

$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=cinema", $user, $pass);

if(isset($_GET['id']) && $_GET['id'] > 0)
{
    $get_id = intval($_GET['id']);
    $requete_user = $db->query("SELECT * FROM `user` WHERE id = '" . $get_id . "'");
    $user_info = $requete_user->fetch();
?>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <title>MyCinema</title>
    </head>
    <body>
        <nav>
            <a href="index.php"> <!-- A modif -->
                <img src="assets/engrenage.png" alt="image d'accueil" width="2.5%" height="2.5%" title="Accueil">
            </a>
        </nav>

        <br>
        <br>

        <!--formulaire-->
        <div align="center">
            <h3>Profil de <?php echo $user_info['lastname'] . ", " . $user_info['firstname'];?></h3>
            <br><br><br>
            Lastname = <?php echo $user_info['lastname'];?>
            <br>
            Firstname = <?php echo $user_info['firstname'];?>
            <br>
            Email = <?php echo $user_info['email'];?>
            <br>
            <?php
                if(isset($_SESSION['id']) && $user_info['id'] == $_SESSION['id'])
                {
                    ?>
                    <a href="edition.php">Editer mon profil</a>
                    <a href="deconnexion.php">Deconnexion</a>
                    <?php
                }
            ?>
        </div>
    </body>
    </html>
<?php
}
else
{

}
?>