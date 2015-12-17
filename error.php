<?php
$errorCode = "";
$errorMsg = "";

if (!empty($_GET['errorCode'])){

    // Handle Error Messages
    $errorCode = $_GET['errorCode'];

    if(strcmp($errorCode,'No_URL')==0){
        $errorMsg = "Please input URL.";
    }

    if(strcmp($errorCode,'Invalid_URL')==0){
        $errorMsg = "Please input a valid URL.";
    }

    if(strcmp($errorCode,'NOTEXIST_URL')==0){
        $errorMsg = "The URL is not found. Kindly check if its available first.";
    }
}

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Link Shortener | Luiz Santos</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">ikLi - Link Shortener</h1>
            </header>
        </div>

        <div class="main-container">
            <div class="main wrapper clearfix">

                <article>
                    <header>
                        <h1>Paste your URL here:</h1>
                        <form action="submit.php" method="post">
                            <input type="text" name="url" size="60" />
                            <input type="submit" value="Shorten">
                        </form>
                    </header>
                    <footer>
                        <?php 
                        echo "<h1 style='color:#e74c3c;'> Oops!</h1>"; 
                        echo "<h3>" . $errorMsg . "</h3>";
                        ?>
                    </footer>
                </article>

                <aside>
                    <h3>ikli (maikli) adj.</h3>
                    <p>1. Filipino word for not long: maigsi, maikli</p>
                    <p>2. not tall: pandak, mababa, maikli</p>
                    <p>3. less than the right amount, measure, standard, etc.: kulang, kapos adv. 1. suddenly: biglang-bigla</p>
                    <p>4. briefly: madali, sandali lamang, maigsi, maikli</p>
                    <p>5. to cut short, to end suddenly: tumapos (matapos, tapusin) nang biglaan, biglang tumapos (matapos, tapusin)</p>
                </aside>

            </div> <!-- #main -->
        </div> <!-- #main-container -->

        <div class="footer-container">
            <footer class="wrapper">
                <h3>Luiz Philip M. Santos: Mindvalley Coding Challenge</h3>
            </footer>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/main.js"></script>
    </body>
</html>
