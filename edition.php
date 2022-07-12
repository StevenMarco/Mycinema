<?php
session_start();

$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=cinema", $user, $pass);

if(isset($_SESSION['id']))
{
    $requete_user = $db->query("SELECT * FROM `user` WHERE id = '" . $_SESSION['id'] . "'");
    $user_info = $requete_user->fetch();

        if((isset($_POST['new_email']) && !empty($_POST['new_email'])) && ($_POST['new_email'] != $user_info['email']))
        {
            $new_email = htmlspecialchars($_POST['new_email']);
            $insert_email = $db->query("UPDATE `user` SET email = '" . $new_email . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_email->fetch();
            header("Location: profil.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_firstname']) && !empty($_POST['new_firstname'])) && ($_POST['new_firstname'] != $user_info['firstname']))
        {
            $new_firstname = htmlspecialchars($_POST['new_firstname']);
            $insert_firstname = $db->query("UPDATE `user` SET firstname = '" . $new_firstname . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_firstname->fetch();
            header("Location: profil.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_lastname']) && !empty($_POST['new_lastname'])) && ($_POST['new_lastname'] != $user_info['lastname']))
        {
            $new_lastname = htmlspecialchars($_POST['new_lastname']);
            $insert_lastname = $db->query("UPDATE `user` SET lastname = '" . $new_lastname . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_lastname->fetch();
            header("Location: profil.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_address']) && !empty($_POST['new_address'])) && ($_POST['new_address'] != $user_info['address']))
        {
            $new_address = htmlspecialchars($_POST['new_address']);
            $insert_address = $db->query("UPDATE `user` SET address = '" . $new_address . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_address->fetch();
            header("Location: profil.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_zipcode']) && !empty($_POST['new_zipcode'])) && ($_POST['new_zipcode'] != $user_info['zipcode']))
        {
            $new_zipcode = htmlspecialchars($_POST['new_zipcode']);
            $insert_zipcode = $db->query("UPDATE `user` SET zipcode = '" . $new_zipcode . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_zipcode->fetch();
            header("Location: profil.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_city']) && !empty($_POST['new_city'])) && ($_POST['new_city'] != $user_info['city']))
        {
            $new_city = htmlspecialchars($_POST['new_city']);
            $insert_city = $db->query("UPDATE `user` SET city = '" . $new_city . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_city->fetch();
            header("Location: profil.php?id=" . $_SESSION['id']);
        }
        if((isset($_POST['new_country']) && !empty($_POST['new_country'])) && ($_POST['new_country'] != $user_info['country']))
        {
            $new_country = htmlspecialchars($_POST['new_country']);
            $insert_country = $db->query("UPDATE `user` SET country = '" . $new_country . "' WHERE id = '" . $_SESSION['id'] . "'");
            $user_info = $insert_country->fetch();
            header("Location: profil.php?id=" . $_SESSION['id']);
        }

        if((isset($_POST['new_password']) && !empty($_POST['new_password'])) && (isset($_POST['confirm_new_password']) && !empty($_POST['confirm_new_password'])))
        {
            $mdp1 = sha1($_POST['new_password']);
            $mdp2 = sha1($_POST['confirm_new_password']);

            if($mdp1 == $mdp2)
            {
                $insert_password = $db->query("UPDATE `user` SET motdepasse = '" . $mdp1 . "' WHERE id = '" . $_SESSION['id'] . "'");
                $user_info = $insert_password->fetch();
                header("Location: profil.php?id=" . $_SESSION['id']);

            }
            else
            {
                $erreur = "Les mots de passe de sont pas identiques";
            }
        }
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
        <div align="left">
            <h3>Edition du profil</h3>
            <br><br><br>
            <form action="" method="post">
                <label for="new_email">Email :</label>
                    <input type="email" name="new_email" id="" placeholder="new_email" value="<?php echo $user_info['email']?>"> <br> </br>
                <label for="new_firstname">Firstname :</label>
                    <input type="text" name="new_firstname" id="" placeholder="new_firstname" value="<?php echo $user_info['firstname']?>"> <br> </br>
                <label for="new_lastname">Lastname :</label>
                    <input type="text" name="new_lastname" id="" placeholder="new_lastname" value="<?php echo $user_info['lastname']?>"> <br> </br>
                <label for="new_birthdate">Birthdate :</label>
                    <input type="date" name="new_birthdate" id="" value="<?php echo $user_info['birthdate']?>"> <br> </br>
                <label for="new_address">Address :</label>
                    <input type="text" name="new_address" id="" placeholder="new_address" value="<?php echo $user_info['address']?>"> <br> </br>
                <label for="new_zipcode">Zipcode :</label>
                    <input type="number" name="new_zipcode" id="" placeholder="new_zipcode" value="<?php echo $user_info['zipcode']?>"> <br> </br>
                <label for="new_city">City :</label>
                    <input type="text" name="new_city" id="" placeholder="new_city" value="<?php echo $user_info['city']?>"> <br> </br>
                <label for="new_country">Country :</label>
                    <input type="text" name="new_country" id="" placeholder="new_country" value="<?php echo $user_info['country']?>"> <br> </br>
                <label for="new_password">Password :</label>
                    <input type="password" name="new_password" id="" placeholder="new_password"> <br> </br>
                <label for="confirm_new_password">Confirm Password :</label>
                    <input type="password" name="confirm_new_password" id="" placeholder="confirm new_password"> <br> </br>
                <input type="submit" value="Mise à jour du profil">
            </form>
            <?php
                if(isset($erreur))
                {
                    ?>
                        <font color='red'><?=$erreur?></font>
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
    header("Location: connexion.php");
}
?>