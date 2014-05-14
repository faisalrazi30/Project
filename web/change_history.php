<?php
include_once 'includes/psl-config.php';
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
    <link rel="stylesheet" href="css/pure.css" />
    <link rel="stylesheet" href="css/pure-form.css" />
    <link rel="stylesheet" href="css/side-menu.css">
</head>

<?php if (login_check($mysqli) == true) : ?>
<?php if (0 < $_REQUEST['wid']) { $wid = $_REQUEST['wid']; } ?>
<input type='hidden' name='wid' value='$wid'>
<?php if ($_REQUEST['wid'] > 0) : ?>

<div id="layout">
    <a href="" id="menuLink" class="menu-link">
        <span></span>
    </a>

    <?php menu(); ?>

    <div id="main">
        <div class="header">
            <h1>Tilføj tid til projekt</h1>
        </div>

        <div class="content">
            <h2 class="content-subhead"></h2>
            
            <form class="pure-form pure-form-stacked" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>"   name="registration_form">
                      <?php
                    echo '<input type="hidden" name="wid" value="' .$wid .'">';
                    ?>
                <?php upate_history($mysqli,$wid); ?>
                <ul><li> Indtast ændringer </li></ul>
                <div>
                    <label for="timer"><b>Timer</b></label>
                    <input id ="timer" type="text" name="timer" required />
                </div>
                    <br><br>
                <div>
                    <label for="date"><b>Dato</b></label>
                    <input id="date" type="text" name="date" required/>
                </div>
                <br><br>
                <div>
                    <label for="info"><b>Beskrivelse</b></label>
                    <textarea id="info" type="text" name="info" rows="4" cols="50"></textarea>
                </div>
                <br><br>
                <div>
                    <br><br>
                    <input class="btn right" type="submit" value="Tilføj timer"/> 

                </div>

                <?php
                    if(isset($_REQUEST['timer'], $_REQUEST['date'], $_REQUEST['info'])) {
                        $timer = $_REQUEST['timer'];
                        $dato = $_REQUEST['date'];
                        $info = $_REQUEST['info'];
                        $userid = $_SESSION['user_id'];
                       
                        $SQL = // Update statement with $timer, $dato, $info, $userid and $wid.

                        if ($insert = $mysqli->prepare($SQL)){
                                if (!$insert->execute()) {
                                    header('Location: ../error.php?err=Registration failure: INSERT');
                                
                            }
                        header('Location: ./history.php');
                        
                        }
                    }
                ?>
            </form>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
    <?php else : ?>
        <?php header('Location: ./history.php');
        die();?>
    <?php endif; ?> 
    <?php else : ?>
        <p>
            <span class="error">Du har ikke rettigheder til at komme ind på siden.</span> Gå venligst tilbage til <a href="index.php">login siden</a>.
        </p>
    <?php endif; ?>

</body>

</html>