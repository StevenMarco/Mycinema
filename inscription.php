<?php
$user = "root";
$pass = "root";
$db = new PDO("mysql:host=localhost;dbname=cinema", $user, $pass);

    // php formulaire
    if((isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['password']) && !empty($_POST['password'])))
    {
        // security
        $email = htmlspecialchars($_POST['email']);
        $confirm_email = htmlspecialchars($_POST['confirm_email']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $address = htmlspecialchars($_POST['address']);
        $city = htmlspecialchars($_POST['city']);
        $birthdate = htmlspecialchars($_POST['birthdate']);
        $zipcode = htmlspecialchars($_POST['zipcode']);
        $country = htmlspecialchars($_POST['country']);
        $password = sha1($_POST['password']);
        $confirm_password = sha1($_POST['confirm_password']);

                if($email == $confirm_email)
                {
                    if(filter_var($email, FILTER_VALIDATE_EMAIL))
                    {
                        if($password == $confirm_password)
                        {
                            $requete_mail = $db->query("SELECT COUNT(*) AS 'email' FROM user WHERE email = '" . $email . "'");
                            $requete = $requete_mail->fetch(PDO::FETCH_OBJ);
                            $mail_exist = $requete->email;
                            if($mail_exist == 0)
                            {

                                // add ID
                                $result = $db->query("SELECT * FROM `user` ORDER BY `id` DESC LIMIT 1;");
                                $movie = $result->fetch(PDO::FETCH_OBJ);
                                $new_id = $movie->id + 1; 
                                // INSERT INTO
                                $result = $db->query("INSERT INTO user 
                                                    VALUES ('" . $new_id . "', '" 
                                                    . $email . "', '" 
                                                    . $firstname . "', '" 
                                                    . $lastname . "', '" 
                                                    . $birthdate . "', '" 
                                                    . $address . "', '"
                                                    . $zipcode . "', '"
                                                    . $city . "', '"
                                                    . $country . "', '"
                                                    . $password . "');");
                                $movie = $result->fetch(PDO::FETCH_OBJ);
                                $_SESSION['compte_valide'] = "Votre compte a bien été créer. Merci de votre inscription.";
                                header('Location: index.php');
                            }
                            else
                            {
                                $erreur = "Cette adresse mail est déja utilisé.";
                            }
                        }
                        else
                        {
                            $erreur = "Attention, votre mot de passe ne correspond pas avec la comfirmation.";
                        }
                    }
                    else
                    {
                        $erreur = "Attention, votre adresse mail n'est pas valide, veuillez la vérifier.";
                    }
                }
                else
                {
                    $erreur = "Attention, votre adresse mail ne correspond pas avec la comfirmation.";
                }
        }
        else
        {
            $erreur = "Veuillez remplir tous les champs.";
        }
    ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>MyCinema</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
    <nav>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Série</a>
            </li>
            <li class="nav-item">
                <a class="nav-link">DVD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Streaming</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Kids</a>
            </li>
            <li class="nav-item dropdown" >
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Options</a>
                <ul class="dropdown-menu" >
                <li><a class="dropdown-item" href="inscription.php">Inscription</a></li>
                <li><a class="dropdown-item" href="connexion.php">Connexion</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">prendre votre billet</a>
            </li>
            <li class="nav-item" id="nav_membres">
                <a class="nav-link" href="member.php">Membres</a>
            </li>
        </ul>
    </nav>

    <br>
    <br>

    <!--formulaire-->
    <div align="center">
        <h3>Inscription</h3>
        <br><br><br>
        <form action="" method="post">
            <table>
                <!--email-->
                <tr>
                    <td>
                        <label for="email">email:</label>
                    </td>
                    <td>
                        <input type="email" name="email" id="email" placeholder="email" value="<?= (isset($email)) ? $email : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="confirm_email">confirm email:</label>
                    </td>
                    <td>
                        <input type="email" name="confirm_email" id="confirm_email" placeholder="confirm email" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="firstname">firstname:</label>
                    </td>
                    <td>
                        <input type="text" name="firstname" id="firstname" placeholder="firstname" value="<?= (isset($firstname)) ? $firstname : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="lastname">lastname:</label>
                    </td>
                    <td>
                        <input type="text" name="lastname" id="lastname" placeholder="lastname" value="<?= (isset($lastname)) ? $lastname : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="birthdate">birthdate:</label>
                    </td>
                    <td> 
                        <input type="date" name="birthdate" id="birthdate" required>
                    </td> 
                </tr>

                <tr>
                    <td>
                        <label for="address">address:</label>
                    </td>
                    <td>
                        <input type="text" name="address" id="address" placeholder="address" value="<?= (isset($address)) ? $address : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="zipcode">zipcode:</label>
                    </td>
                    <td>
                        <input type="number" name="zipcode" id="zipcode" placeholder="zipcode ex:09800" value="<?= (isset($zipcode)) ? $zipcode : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="city">city:</label>
                    </td>
                    <td>
                        <input type="text" name="city" id="city" placeholder="city" value="<?= (isset($city)) ? $city : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="country">country:</label>
                    </td>
                    <td>
                        <input type="text" name="country" id="country" placeholder="country" value="<?= (isset($country)) ? $country : ''?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="password">password:</label>
                    </td>
                    <td>
                        <input type="password" name="password" id="password" placeholder="mot de passe" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="confirm_password">confirm password:</label>
                    </td>
                    <td>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="confirmer votre mot de passe" required>
                    </td>
                </tr>

                <tr>
    
                    <td>
                        <label for=""></label>
                    </td>
                    <td align="center">
                        <br>
                        <input type="reset" value="reset">
                        <input type="submit" value="inscritpion" name="form_inscription">
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
        <br>
        <button name="connexion_button" id="connexion_button" value="Connexion"><a href="connexion.php">Connexion</a></button>
    </div>
</body>
</html>