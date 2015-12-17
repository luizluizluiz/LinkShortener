 <?php                  

 	if (!empty($shortened)){
 		echo"<h1 style='color: #2ecc71;'> Success! </h1>";
    	echo"<h3>Here's your short URL:</h3>";
        echo"<p>". $shortened . "</p>";
    	echo"<h3>from: </h3>";
        echo"<p>". $longURL . "</p>";
    }
 ?>