<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure.css">
    <link rel="stylesheet" href="css/pure.css"/>
    <link rel="stylesheet" href="css/pure-form.css" />
    <link rel="stylesheet" href="css/layouts/side-menu.css">
</head>

    <?php if (login_check($mysqli) == true) : ?>
    <?php if (check_admin($mysqli) == true) : ?>
    
    <div id="layout">
        <a href="#menu" id="menuLink" class="menu-link">
            <span></span>
        </a>

        <div id="menu">
            <div class="pure-menu pure-menu-open">
                <a class="pure-menu-heading" align="center" href="main.php"><img src="img/logo1.png"></a>

                <ul>
                    <li><a href="all_projects.php">Tilbage</a></li>
                </ul>
            </div>
        </div>

        <div id="main">
            <div class="header">
                <h1>Opret nyt projekt</h1>
                <h2>Udfyld følgende for oprette et nyt projekt</h2>
            </div>

            <div class="content">
                <h2 class="content-subhead"></h2>
            
                <form class="pure-form pure-form-stacked" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                <fieldset>
                    <div>
                        <label for="projectname"><b>Projekt navn</b></label>
                        <input id="projectname" type="text" placeholder="Indtast navn" required/>
                    </div>
                    <br><br>
                    <div>
                        <label for="category"><b>Kategori</b></label>
                        <select><a href="#">Tilføj ny kategori</a>
                            <option id="category" value="0" required>Vælg kategori</option>
                        </select>
                        <br><br>
                        <a href="#">Tilføj ny kategori</a>
                    </div>
                    <br>
                    <div>
                        <label for="date"><b>Dato</b></label>
                        <input id="date" type="date"/ required>
                    </div>
                    <br><br>
                    <label for="info"><b>Info</b></label>
                    <textarea id="info" type="text" rows="4" cols="50"></textarea>
                    <br><br><br><br>
                    <input class="btn right" type="submit" value="Tilføj projekt"> 
                </fieldset>

            <?php
                if(isset($_REQUEST['projectname'], 
                         $_REQUEST['category'], 
                         $_REQUEST['date'], 
                         $_REQUEST['info'])) {

                    $project_name = $_REQUEST['project_name'];
                    $category     = $_REQUEST['category'];
                    $date         = $_REQUEST['date'];
                    $info         = $_SESSION['info'];

                    if ($insert_stmt = $mysqli->prepare(
                        "INSERT INTO projekt (user_id, project_name, category, date, info) VALUES (?, ?, ?, ?, ?)")) {
                        $insert_stmt->bind_param($_SESSION['user_id'], $project_name, $category, $date, $info);

                        if (! $insert_stmt->execute()) {
                            header('Location: ../error.php?err=Registration failure: INSERT');
                        }
                    }
                    header('Location: ./all_projects.php');
                }
            ?>
            </form>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>
</body>
    <?php else : ?>
        <?php header('Location: ./main.php'); ?>
    <?php endif ; ?>
    <?php else : ?>
        <p>
            <span class="error">Du har ikke rettigheder til at komme ind på siden.</span> Gå venligst tilbage til <a href="index.php">login siden</a>.
        </p>
    <?php endif; ?>
</body>

</html>
