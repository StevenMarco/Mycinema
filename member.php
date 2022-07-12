<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>MyCinema</title>
</head>

<body>
    <nav>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Accueil</a>
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
            <li class="nav-item active" aria-current="page" id="nav_membres">
                <a class="nav-link active" href="member.php">Membres</a>
            </li>
        </ul>
    </nav>

    <br>
    <br>

    <form action="" method="get">
        <label>Shearch memberships :</label>
        <input type="text" name="name" id="" placeholder="firstname or lastname">
        <input type="text" name="lastname" id="" placeholder="lastname for more precision">
        <input type="submit" value="submit">
        <br>
        <p>--------</p>
    </form>
    
<?php

$user = "root";
$pass = "root";
$name = $_GET['name'];
$lastname = $_GET['lastname'];

try {
    $db = new PDO("mysql:host=localhost;dbname=cinema", $user, $pass);
} catch (PDOException $e) {
    print "Erreur :" . $e->getMessage() . "<br />";
    die;
}

// pour trouver par firstname et lastname
if(isset($_GET['name']) && !empty($_GET['name']))
{
    if(isset($_GET['lastname']) && !empty($_GET['lastname']))
    {
        $movie = "SELECT * FROM user 
        LEFT JOIN membership ON user.id = membership.id_user 
        WHERE lastname LIKE '%" . $lastname . "%' AND firstname LIKE '%" . $name . "%'";        
    }
    else
    {
        $movie = "SELECT * FROM user 
        LEFT JOIN membership ON user.id = membership.id_user 
        WHERE lastname LIKE '%" . $name . "%' OR firstname LIKE '%" . $name . "%'";
    }

                // on determine sur quelle page on se trouve
                if(isset($_GET['page']) && !empty($_GET['page']))
                {
                    $currentPage = (int) strip_tags($_GET['page']);
                }
                else
                {
                    $currentPage = 1;
                }
                // on détermine le nbr total
                $result = $db->query($movie);
                $result_final = $result->fetchAll();
                $nbArticles = (int) count($result_final);

                // déterminer le nbr d'aerticles par page
                $parPage = 50;

                // on calcul le nbr de pages total
                $pages = ceil($nbArticles / $parPage);

                // calcul le première article de la page
                $premier = ($currentPage * $parPage) - $parPage;

                // LIMIT de la page
                $movie .= " LIMIT $premier, $parPage";

                $result = $db->query($movie);
                $result_final = $result->fetchAll();
    
        ?>
        <table class="table">
            <thead>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Number membership</th>
                <th>Actually Subscription</th>
            </thead>
            <tbody>
                <?php
                foreach($result_final as $resultat)
                {           
                ?>
                    <tr>
                        <td><?= $resultat['firstname'] ?></td>
                        <td><?= $resultat['lastname'] ?></td>
                        <?php
                        if($resultat['id_user'] == NULL)
                        {
                            ?>
                            <td>No member</td>
                            <?php
                        }
                        else
                        {
                            ?>
                            <td><?= $resultat['id_user']?></td>
                            <?php
                        }
                        
                        if($resultat['id_subscription'] == 1)
                        {
                            ?>
                            <td>VIP 
                            <form action="" method="post">
                                    <input type="number" name="id_user" id="" value="<?=$resultat['id_user']?>" hidden>
                                    <select name="sub" id="">
                                    <option value="" selected>-></option>
                                        <?php
                                        $result = $db->query("SELECT * FROM `cinema`.`subscription`");
                                        $subscriptions = $result->fetchAll();
                                        foreach($subscriptions as $subscription)
                                        {
                                            ?>
                                            <option value="<?=$subscription['id']?>"><?=$subscription['name']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="submit" value="Ok">
                                </form>
                            </td>
                            <?php
                        }
                        elseif($resultat['id_subscription'] == 2)
                        {
                            ?>
                            <td>GOLD 
                            <form action="" method="post">
                                    <input type="number" name="id_user" id="" value="<?=$resultat['id_user']?>" hidden>
                                    <select name="sub" id="">
                                    <option value="" selected>-></option>
                                        <?php
                                        $result = $db->query("SELECT * FROM `cinema`.`subscription`");
                                        $subscriptions = $result->fetchAll();
                                        foreach($subscriptions as $subscription)
                                        {
                                            ?>
                                            <option value="<?=$subscription['id']?>"><?=$subscription['name']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="submit" value="Ok">
                                </form>
                            </td>
                            <?php
                        }
                        elseif($resultat['id_subscription'] == 3)
                        {
                            ?>
                            <td>Classic 
                                <form action="" method="post">
                                    <input type="number" name="id_user" id="" value="<?=$resultat['id_user']?>" hidden>
                                    <select name="sub" id="">
                                    <option value="" selected>-></option>
                                        <?php
                                        $result = $db->query("SELECT * FROM `cinema`.`subscription`");
                                        $subscriptions = $result->fetchAll();
                                        foreach($subscriptions as $subscription)
                                        {
                                            ?>
                                            <option value="<?=$subscription['id']?>"><?=$subscription['name']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="submit" value="Ok">
                                </form>
                            </td>
                            <?php
                        }
                        elseif($resultat['id_subscription'] == 4)
                        {
                            ?>
                            <td>Pass Day 
                            <form action="" method="post">
                                    <input type="number" name="id_user" id="" value="<?=$resultat['id_user']?>" hidden>
                                    <select name="sub" id="">
                                    <option value="" selected>-></option>
                                        <?php
                                        $result = $db->query("SELECT * FROM `cinema`.`subscription`");
                                        $subscriptions = $result->fetchAll();
                                        foreach($subscriptions as $subscription)
                                        {
                                            ?>
                                            <option value="<?=$subscription['id']?>"><?=$subscription['name']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="submit" value="Ok">
                                </form>
                            </td>
                            <?php
                        }
                        else
                        {
                            ?>
                            <td>Ø
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                <?php
                }
                if(isset($_POST['sub']) && !empty($_POST['sub']))
                {      
                    $result = $db->query("UPDATE membership SET id_subscription = '" . $_POST["sub"] . "', date_begin = '" . date('Y-m-d H:i:s') . "' WHERE id_user = '" . $_POST['id_user'] . "';");
                    $movie = $result->fetch(PDO::FETCH_OBJ);
                }  
                ?>
            </tbody>
        </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="?name=<?=$_GET['name']?>&lastname=<?=$_GET['lastname']?>&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php
                        for($page = 1; $page <= $pages; $page++)
                        {
                        ?>
                            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="?name=<?=$_GET['name']?>&lastname=<?=$_GET['lastname']?>&page=<?= $page ?>" class="page-link"><?= $page?></a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="?name=<?=$_GET['name']?>&lastname=<?=$_GET['lastname']?>&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </nav>
        <?php
}
?>

<br>
<br>
<br>
<!-- add new user -->
<p>---------------------------------------------------------------------------</p>

    <form action="" method="post">
        <label>add new user :</label> <br>
        <input type="email" name="email" id="" placeholder="email" required> <br> 
        <input type="text" name="firstname" id="" placeholder="firstname" required> <br>
        <input type="text" name="lastname" id="" placeholder="lastname" required> <br>
        <input type="date" name="birthdate" id="" required> <br>
        <input type="text" name="address" id="" placeholder="address" required> <br>
        <input type="number" name="zipcode" id="" placeholder="zipcode" required> <br>
        <input type="text" name="city" id="" placeholder="city" required> <br>
        <input type="text" name="country" id="" placeholder="country" required> <br>
        <p>si Abonnement : 1=VIP; 2=GOLD; 3=Classic; 4=Pass <br>Jour&heure de l'abbonement</p>
        <input type="number" name="subscription" id="" placeholder="subscription">
        <input type="datetime-local" name="datetime" id="">
        <br>
        <br>
        <input type="reset" value="reset">
        <input type="submit" value="submit">
        <br>
        <p>--------</p>
    </form>

<?php

if((isset($_POST['firstname']) && !empty($_POST['firstname'])) && (isset($_POST['lastname']) && !empty($_POST['lastname'])))
{
    $result = $db->query("SELECT * FROM `user` ORDER BY `id` DESC LIMIT 1;");
    $movie = $result->fetch(PDO::FETCH_OBJ);
    $new_id = $movie->id + 1;
    
    $result = $db->query("INSERT INTO user 
                        VALUES ('" . $new_id . "', '" 
                        . $_POST['email'] . "', '" 
                        . $_POST['firstname'] . "', '" 
                        . $_POST['lastname'] . "', '" 
                        . $_POST['birthdate'] . "', '" 
                        . $_POST['address'] . "', '"
                        . $_POST['zipcode'] . "', '"
                        . $_POST['city'] . "', '"
                        . $_POST['country'] . "');");
    $movie = $result->fetch(PDO::FETCH_OBJ);
};         

if((isset($_POST['subscription']) && !empty($_POST['subscription'])) && (isset($_POST['datetime']) && !empty($_POST['datetime'])))
{
    $result = $db->query("SELECT id FROM membership ORDER BY id DESC LIMIT 1;");
    $movie = $result->fetch(PDO::FETCH_OBJ);
    $new_new_id = $movie->id + 1;

    $result = $db->query("INSERT INTO membership VALUES('" . $new_new_id . "', '" . $new_id . "', '" . $_POST['subscription'] . "', '" . $_POST['datetime'] . "');");
    $movie = $result->fetch(PDO::FETCH_OBJ);
};
?>

<p>---------------------------------------------------------------------------</p>
<p>Ajouter un nouveaux membres :</p>
<form action="" method="post">
    <input type="text" name="add_firstname" id="" placeholder="firstname" required>
    <input type="text" name="add_lastname" id="" placeholder="lastname" required>
    <input type="email" name="add_email" id="" placeholder="email" required>
    <select name="add_sub" id="">
    <option value="" selected>-></option>
        <?php
        $result = $db->query("SELECT * FROM `cinema`.`subscription`");
        $subscriptions = $result->fetchAll();
        foreach($subscriptions as $subscription)
        {
            ?>
            <option value="<?=$subscription['id']?>"><?=$subscription['name']?></option>
            <?php
        }
        ?>
    </select>
    <input type="submit" value="Ajouter">
</form>

<?php
    if((isset($_POST['add_email']) && !empty($_POST['add_email']) && (isset($_POST['add_sub']) && !empty($_POST['add_sub']))))
    {
        $number = $db->query("SELECT * FROM membership ORDER BY id DESC LIMIT 1;");
        $movie = $number->fetch(PDO::FETCH_OBJ);
        $new_id = $movie->id + 1;

        $result = $db->query("SELECT * FROM user WHERE (firstname = '" . $_POST['add_firstname'] . "' AND lastname = '" . $_POST['add_lastname'] . "') AND email = '" . $_POST['add_email'] . "';");
        $subscriptions = $result->fetch(PDO::FETCH_OBJ);
        $id_user = $subscriptions->id;

        $insert_result = $db->query("INSERT INTO membership VALUES('" . $new_id . "', '" . $id_user . "', '" . $_POST['add_sub'] . "', '" . date('Y-m-d H:i:s') . "');");
        $new_sub = $insert_result->fetchAll();

        echo "<script>alert(\"Le nouveau membre à été ajouté\")</script>";
    }
?>

<p>---------------------------------------------------------------------------</p>
    <form action="" method="post">
        <label>Delete one member :</label>
            <br>
            <p>Attention ! Toute supression est définitive ! </p>
        <input type="number" name="id_user_delete" id="" placeholder="number membership"> 
        <input type="number" name="verification_id_user" id="" placeholder="comfirm number membership">
        <input type="submit" value="Supprimer">
        <br>
        <p>--------</p>
    </form>

    <?php
        if((isset($_POST['id_user_delete']) && !empty($_POST['id_user_delete'])) && (isset($_POST['verification_id_user']) && !empty($_POST['verification_id_user'])))
        {
            if($_POST['id_user_delete'] == $_POST['verification_id_user'])
            {
                echo "Le membre numéro" . $_POST['verification_id_user'] . "a bien été supprimer de la base de donnée.";
                $result = $db->query("DELETE FROM membership WHERE id_user = '" . $_POST['verification_id_user'] . "';");
                $movie = $result->fetch(PDO::FETCH_OBJ);
            }
            elseif($_POST['id_user_delete'] !== $_POST['verification_id_user'])
            {
                echo "Une erreur c'est produite, vérifié le numéro client demandé.";
            }
        }

        ?>
        <p>---------------------------------------------------------------------------</p>

        <form action="" method="post">
            <label>Ajouter de l'historique à un membre:</label> <br>
            <input type="text" name="firstname_members" id="" placeholder="firstname">
            <input type="text" name="lastname_members" id="" placeholder="lastname">
            <input type="email" name="email_members" id="" placeholder="email">
            <input type="text" name="title_movie_members" id="" placeholder="titre du film">
            <input type="text" name="name_room_members" id="" placeholder="nom de la room">
            <input type="reset" value="Reset">
            <input type="submit" value="Envoyer"> 
        </form>
        <?php
        // // recherche de membership_log
        //     $result = $db->query("SELECT user.id AS userID FROM user WHERE firstname = '" . $_POST['firstname_members'] . "' AND lastname = '" . $_POST['lastname_members'] . "' AND email = '" . $_POST['email_members'] . "'");
        //     $movie = $result->fetch(PDO::FETCH_OBJ);
        //     $user_id = $movie->userID;

        //     $result = $db->query("SELECT id FROM membership WHERE id_user = '" . $user_id . "'");
        //     $movie = $result->fetch(PDO::FETCH_OBJ);
        //     $membership_id = $movie->id;
        // // recherche d'id_session
        //     $result = $db->query("SELECT * FROM movie WHERE title = '" . $_POST['title_movie_members'] . "'");
        // // ajouter fonction création d'un movie scedule si NULL sinon prendre l'id


        // // ajouter un historique membre
        //     $result = $db->query("INSERT INTO membership_log VALUES ('" . $membership_id . "', '" . $vdvzvezvzvz . "')");
        //     $movie = $result->fetch(PDO::FETCH_OBJ);
        ?>

        <br>
        <p>---------------------------------------------------------------------------</p>
<p>Attention veuillez notifier le numéro client. (elle vous est donnée dans la 'search members' si besoin) <br> 
    La date n'est pas obligatoire, mais peut être utilisé pour préciser votre recherche.</p>
<form action="" method="post">
    <label>Chercher l'historique d'un member:</label>
    <input type="number" name="id_member" id="" placeholder="number membership" required>
    <input type="date" name="chosen_date" id=""> 
    <input type="submit" value="Voir">
    <br>
    <p>--------</p>
</form>

<?php

if(isset($_POST['id_member']) && !empty($_POST['id_member']))
{
    if(isset($_POST['chosen_date']) && !empty($_POST['chosen_date']))
    {
        $result = $db->query("SELECT * FROM movie_schedule LEFT JOIN membership_log ON movie_schedule.id = membership_log.id_session WHERE id_membership = " . $_POST['id_member'] ." AND date_begin LIKE '%" . $_POST['chosen_date'] . "%';");
    }
    else
    {
        $result = $db->query("SELECT * FROM movie_schedule LEFT JOIN membership_log ON movie_schedule.id = membership_log.id_session WHERE id_membership = " . $_POST['id_member'] .";");
    }       

    while($movie = $result->fetch(PDO::FETCH_OBJ))
    {
        ?>
        <p>
            <strong>Date de visionnage</strong> : <?=$movie->date_begin?> <br>
        </p>
        <?php
        $var = $movie->id_movie;
        $id_movie = $db->query("SELECT * FROM movie WHERE id = '" . $var . "';");
        $movie = $id_movie->fetch(PDO::FETCH_OBJ);
        ?>
        <p>
            <strong>Film vu</strong> : <?=$movie->title?> <br> <br>
        </p>
        <?php
    }
}  
?>
<p>---------------------------------------------------------------------------</p>
<p>ajouter une séance :</p>
<form action="" method="post">
    <input type="text" name="name_movie" id="" placeholder="titre du film" required>
    <input type="text" name="name_room" id="" placeholder="nom de la room" required>
    <input type="datetime-local" name="date_begin" id="" required>
    <input type="submit" value="Ajouter">
</form>
<?php
if((isset($_POST['name_movie']) && !empty($_POST['name_movie'])) && (isset($_POST['date_begin']) && !empty($_POST['date_begin'])))
{
    $number = $db->query("SELECT id FROM movie_schedule ORDER BY id DESC LIMIT 1;");
    $movie = $number->fetch(PDO::FETCH_OBJ);
    $new_id = $movie->id + 1;

    $id_movie = $db->query("SELECT * FROM movie WHERE title = '" . $_POST['name_movie'] . "';");
    $movie = $id_movie->fetch(PDO::FETCH_OBJ);
    $set_id_movie = $movie->id;

    $id_room = $db->query("SELECT * FROM room WHERE name = '" . $_POST['name_room'] . "';");
    $room = $id_room->fetch(PDO::FETCH_OBJ);
    $set_id_room = $room->id;

    $insert = $db->query("INSERT INTO movie_schedule VALUES ('$new_id', '$set_id_movie', '$set_id_room', '" . $_POST['date_begin'] . "');");
}
?>
<br>
<br>
<p>---------------------------------------------------------------------------</p>
<p>Date de la séance souhaité :</p>
<form action="" method="post">
    <input type="date" name="date_projection" id="" required>
    <input type="submit" value="Ajouter">
</form>
<?php
    if(isset($_POST['date_projection']) && !empty($_POST['date_projection']))
    {
        $movie = $db->query("SELECT * FROM movie LEFT JOIN movie_schedule ON movie.id = movie_schedule.id_movie WHERE date_begin LIKE '%" . $_POST['date_projection'] . "%' ORDER BY `movie_schedule`.`date_begin` ASC;");
        while($result = $movie->fetch(PDO::FETCH_OBJ))
        {
            ?>
            <p>
                <strong>Film disponible</strong> : <?=$result->title?> <br>
                <strong>Date&heure</strong> : <?=$result->date_begin?> <br>
                    <?php
                    $room_id = $result->id_room;
                    $room = $db-> query("SELECT * FROM room WHERE id = '" . $room_id . "';");
                    $result = $room->fetch(PDO::FETCH_OBJ);
                    ?>
                <strong>Nom de la salle</strong> : <?=$result->name?> <br> <br>
            </p>
                <?php
        }
    }
?>
</body>
</html>