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
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
        <title>Projects</title>
    <link rel="stylesheet" href="css/pure-web.css">
    <link rel="stylesheet" href="css/pure.css"/>
    <link rel="stylesheet" href="css/pure-form.css"/>
    <link rel="stylesheet" href="css/side-menu.css">
</head>

<body>
 <?php if (login_check($mysqli) == true) : ?>
    <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
        <span></span>
    </a>

    <div id='menu'>
            <div class='pure-menu pure-menu-open'>
                <a class='pure-menu-heading' align='center' href='main.php'><img src='img/logo.png'></a>
                    <ul>
                    <li><a href='my_projects.php'>Mine projekter</a></li>
                    <li><a href='all_projects.php'>Alle projekter</a></li>
                    <li><a href='history.php'>Min historik</a></li>
                    <li><a href='contact.php'>Kontakt</a></li>
                    <?php if (check_admin($mysqli) == true) : ?>
                    <li> <a href='new_project.php'>Nyt projekt</a></li>
                    <li> <a href ='sql_table_to_pdf/generate-pdf.php'> Print </a></li>
                    <?php endif; ?>
                    <?php if (check_overadmin($mysqli) == true) : ?>
                    <li> <a href='administrator.php'>Administrator</a></li>
                    <?php endif; ?>
                    <li><a class='logout' href='includes/logout.php'>Log ud</a></li>
                </ul>
            </div>
        </div>

    <?php
        function spamcheck($field) {
        $field=filter_var($field, FILTER_SANITIZE_EMAIL);
        if(filter_var($field, FILTER_VALIDATE_EMAIL)) {
                return TRUE;
            } 
            else {
                return FALSE;
            }
        }
    ?>

    <div id="main">
        <div class="header">
            <h1>Kontakt</h1>
            <h2>Her kan adminstrator kontaktes</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead"></h2>
            
            <form class="pure-form pure-form-stacked" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">


        <?php if (!isset($_POST["submit"])) { ?>
        <div>
            <label for="from"><b>Afsender (E-mail)</b></label>
            <input type="text" name="from" id="from" required>
        </div>
        
        <br><br>
        
        <div>
            <label for="subject"><b>Emne</b></label>
            <input type="text" name="subject" required>
        </div>
        
        <br><br>
        
        <div>
            <label for="message"><b>Besked</b></label>
            <textarea rows="10" cols="40" name="message" required></textarea>
        </div>
        <br><br><br><br><br><br><br><br><br>
            <input class="btn right" type="submit" name="submit" value="Send mail">
        </form>
        
        <?php 
            } 
            else { 
                if (isset($_POST["from"])) {
                    $mailcheck = spamcheck($_POST["from"]);
                    if ($mailcheck==FALSE) {
                        echo "Invalid input";
                    } 
                    else {
                        $to = get_mail($mysqli);
                        $from = $_POST["from"]; 
                        $subject = $_POST["subject"];
                        $message = $_POST["message"];
                        $message = wordwrap($message, 70);
                        mail($to,$subject,$message,"From: $from\n");
                        echo "Tak for mailen - vi svarer tilbage hurtigst muligt!";
                    }
                }
            }
        ?>
        </div>
    </div>


<script src="js/ui.js"></script>

        <?php else : ?>
            <p>
                <span class="error">Du har ikke rettigheder til at komme ind på siden.</span> Gå venligst tilbage til <a href="index.php">login siden</a>.
            </p>
        <?php endif; ?>
</body>
</html>
