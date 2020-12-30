<?php
    session_start();
?>

<!doctype html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
        
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  
    <title>Авто</title>

    <script type="text/javascript">
        $(document).ready(function(){
            
            function all_data()
            {
                $.ajax(
                {
                    type: "POST",
                    url: "php/all_data.php",
                    success: 
                    function(display) 
                    {
                        $("#car_display").html(display).show();
                    }
                });
            }
            
            all_data(); // выводим всё и сразу
        });

    </script>
    
</head>
    
<body>

    <div id="car_display"></div>
    
</body>
</html>