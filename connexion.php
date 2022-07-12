<?php
session_start();

$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=cinema", $user, $pass);


    if(isset($_POST['form_connexion']))
    {
        $email_connect = htmlspecialchars($_POST['email_connect']);
        $password_connect = sha1($_POST['password_connect']);

        if(!empty($email_connect) && !empty($password_connect))
        {
            $requete_user = $db->query("SELECT COUNT(*) AS connexion FROM user 
                                        WHERE email = '" . $email_connect . 
                                        "' AND motdepasse = '" . $password_connect . "'");
            $requete = $requete_user->fetch(PDO::FETCH_OBJ);
            $user_exist = $requete->connexion;
            if($user_exist == 1)
            {
                $info = $db->query("SELECT * FROM user WHERE email = '" . $email_connect . "' AND motdepasse = '" . $password_connect . "'");
                $user_info = $info->fetch();
                $_SESSION['id'] = $user_info['id'];
                $_SESSION['email'] = $user_info['email'];
                $_SESSION['firstname'] = $user_info['firstname'];
                $_SESSION['lastname'] = $user_info['lastname'];
                $_SESSION['birthdate'] = $user_info['birthdate'];
                $_SESSION['address'] = $user_info['address'];
                $_SESSION['zipcode'] = $user_info['zipcode'];
                $_SESSION['country'] = $user_info['country'];
                header("Location: profil.php?id=" . $_SESSION['id']);
            }
            else
            {
                $erreur = "Une erreur d'identifiant ou mot de passe est survenu";
            }
        }
        else
        {
            $erreur = "Tous les champs ne son pas rempli";
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
    <div align="center">
        <h3>Connexion</h3>
        <br><br><br>
        <form action="" method="post">
            <table>
                <!--email-->
                <tr>
                    <td>
                        <label for="email_connect">email:</label>
                    </td>
                    <td>
                        <input type="email" name="email_connect" id="email_connect" placeholder="email" value="<?= (isset($email)) ? $email : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="password_connect">password:</label>
                    </td>
                    <td>
                        <input type="password" name="password_connect" id="password_connect" placeholder="mot de passe" required>
                    </td>
                </tr>

                <tr>
    
                    <td>
                        <label for=""></label>
                    </td>
                    <td align="center">
                        <br>
                        <input type="submit" value="Connexion" name="form_connexion">
                    </td>
                </tr>
            </table>
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