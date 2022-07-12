<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>MyCinema</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>

    <?php

        $user = "root";
        $pass = "root";
        $db = new PDO("mysql:host=localhost;dbname=cinema", $user, $pass);
    ?>

<body>
    <nav>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
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
            <li class="nav-item dropdown">
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
    <div class="table_movie">
        <form action="" method="get">
            <label for="title">Name of the movie :</label>
            <input type="text" name="title" id="" placeholder="title movie">
               
            <select name="genre">
                <option value="" selected>genre :</option>
                    <?php
                        $result = $db->query("SELECT * FROM `cinema`.`genre`");
                        $genres = $result->fetchAll();
                        foreach($genres as $genre)
                        {
                            echo '<option value="' . $genre['id'] . '">' . $genre['name'] . '</option>';
                        }
                    ?>
            </select>
            <select name="distributor">
                <option value="" selected>Producteur :</option>
                    <?php
                        $result_distr = $db->query("SELECT * FROM `cinema`.`distributor`");
                        $distributors = $result_distr->fetchAll();
                        foreach($distributors as $distributor)
                        {
                            echo '<option value="' . $distributor['id'] . '">' . $distributor['name'] . '</option>';
                        }
                    ?>
            </select>
            <br>
            <p>--------</p>
            <input type="submit" value="submit">
        </form>   

    <?php
    if(isset($_GET))
    {
        if(isset($_GET['title']) && !empty($_GET['title']))
        {
            $movie = "SELECT movie.*, distributor.name AS distrib_name, genre.name FROM movie 
                                INNER JOIN distributor ON movie.id_distributor = distributor.id 
                                INNER JOIN movie_genre ON movie.id = movie_genre.id_movie 
                                INNER JOIN genre ON movie_genre.id_genre = genre.id  
                                WHERE title LIKE '%" . $_GET['title'] . "%'";
        }
        if(!empty($_GET['distributor']))
        {
            $movie .= " AND id_distributor = " . $_GET['distributor'];
        }
        if(!empty($_GET['genre']))
        {
            $movie .= " AND id_genre = " . $_GET['genre'];
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
                        <th>Titre</th>
                        <th>Duration movie</th>
                        <th>Home eddition</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach($result_final as $resultat)
                        {
                        ?>
                            <tr>
                                <td><?= $resultat['title'] ?></td>
                                <td><?= $resultat['duration'] ?>min</td>
                                <td><?= $resultat['distrib_name'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="?title=<?=$_GET['title']?>&genre=<?=$_GET['genre']?>&distributor=<?=$_GET['distributor']?>&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php
                        for($page = 1; $page <= $pages; $page++)
                        {
                        ?>
                            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="?title=<?=$_GET['title']?>&genre=<?=$_GET['genre']?>&distributor=<?=$_GET['distributor']?>&page=<?= $page ?>" class="page-link"><?= $page?></a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="?title=<?=$_GET['title']?>&genre=<?=$_GET['genre']?>&distributor=<?=$_GET['distributor']?>&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </nav>
        <?php
    } // if base
        ?>
    </div> 
          <!--carousel-->
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                <h2 align="center">Nos films à la une</h2>
                <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/MORBIUS.jpg" class="d-block w-100" alt="Photo d'introduction au cinema">
                </div>
                <div class="carousel-item">
                    <img src="assets/Doctor Strange_fr.png" class="d-block w-100" alt="Affiche de film Doctor Strange">
                </div>
                <div class="carousel-item">
                    <img src="assets/2400775.jpg" class="d-block w-100" alt="affiche de film">
                </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
                </button>
            </div>
          <!--carousel-->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h5>Nous vous invitons à nous rejoindre sur les réseaux :</h5>
                    </div>
                    <div class="col order-5">
                        <h5>Notre cinéma à l'étranger :</h5>
                    </div>
                    <div class="col order-1">
                        <h5>Restez toujours connecter !</h5>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
