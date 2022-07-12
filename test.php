<!DOCTYPE html>
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
        <a href="index.php">accueil</a>
    </nav>

    <br>
    <br>

    <form action="" method="post">
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
$name = $_POST['name'];
$lastname = $_POST['lastname'];

try {
    $db = new PDO("mysql:host=localhost;dbname=cinema", $user, $pass);
} catch (PDOException $e) {
    print "Erreur :" . $e->getMessage() . "<br />";
    die;
}

// pour trouver par firstname et lastname
if(isset($_POST['name']) && !empty($_POST['name']))
{
    if(isset($_POST['lastname']) && !empty($_POST['lastname']))
    {
        $result = $db->query("SELECT * FROM user INNER JOIN membership ON user.id = membership.id_user WHERE lastname LIKE '%" . $lastname . "%' AND firstname LIKE '%" . $name . "%';");        
    }
    else
    {
        $result = $db->query("SELECT * FROM user INNER JOIN membership ON user.id = membership.id_user WHERE lastname LIKE '%" . $name . "%' OR firstname LIKE '%" . $name . "%';");
    }
    
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
                while($movie = $result->fetch(PDO::FETCH_OBJ))
                {           
                ?>
                    <tr>
                        <td><?= $movie->firstname ?></td>
                        <td><?= $movie->lastname ?></td>
                        <td><?= $movie->id_user ?></td>
                        <td><?= $movie->id_subscription ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php
}
?>

<br>
<br>
<br>

<p>---------------------------------------------------------------------------</p>

    <form action="" method="post">
        <label>add new user/member :</label>
        <input type="email" name="email" id="" placeholder="email" required>
        <input type="text" name="firstname" id="" placeholder="firstname" required>
        <input type="text" name="lastname" id="" placeholder="lastname" required>
        <input type="date" name="birthdate" id="" required>
        <input type="text" name="address" id="" placeholder="address" required>
        <input type="number" name="zipcode" id="" placeholder="zipcode" required>
        <input type="text" name="city" id="" placeholder="city" required>
        <input type="text" name="country" id="" placeholder="country" required>
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
    <p>Attention veuillez notifier le numéro client. (elle vous est donnée dans la 'search members' si besoin)</p>
    <form action="" method="post">
        <label>modif one member :</label>
        <input type="number" name="id_user" id="" placeholder="number membership">
        <input type="number" name="new_sub" id="" placeholder="new subscription">
        <input type="datetime-local" name="modif_date_time" id="">
        <input type="reset" value="reset">
        <input type="submit" value="Modifier">
        <br>
        <p>--------</p>
    </form>
    
    <?php
    if(isset($_POST['id_user']) && !empty($_POST['id_user']))
    {       
        $result = $db->query("UPDATE membership SET id_subscription = '" . $_POST["new_sub"] . "', date_begin = '" . $_POST["modif_date_time"] . "' WHERE id_user = '" . $_POST["id_user"] . "';");
        $movie = $result->fetch(PDO::FETCH_OBJ);
    }  
    ?>

<p>---------------------------------------------------------------------------</p>
    <p></p>
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

<p>---------------------------------------------------------------------------</p>
<p>Projection de la soirée :</p>
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
<?php

/*
while($movie = $result->fetch(PDO::FETCH_OBJ))
{
    ?>
    <p>
    
    </p>
    <?php
} */
?>
</body>
</html>