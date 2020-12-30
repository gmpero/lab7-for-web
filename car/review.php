<?php
    session_start();
    require_once("php/bdconnect.php");
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
            
            var id_brand = <?php echo $_POST['id_brand']; ?>;
            
            function all_review()
            {
                $.ajax(
                {
                    type: "POST",
                    url: "php/all_review.php",
                    data: {id_brand: id_brand},
                    success: 
                    function(display) 
                    {
                        $("#comments").html(display).show();
                    }
                });
            }
            
            all_review(); // выводим все отзывы
            
            var button = $('#button');
            
            button.click(function()
            {
                var id_user = $('input[name=id_user]').val();
                var review = $('textarea[name=text_comment]').val();
                var score = $('#score').val();
                
                $('#err').text("AAA");
                
                $.ajax(
                {
                    type: "POST",
                    url: "php/add_review.php",
                    data: 
                    {
                        id_user: id_user,
                        review: review,
                        score: score,
                        id_brand: id_brand 
                    },
                    success:
                    function()
                    {
                        all_review(); // выводим все отзывы
                       
                    }
                });
                
            });
        });

    </script>
    
</head>
<body>
    <?php
        if(isset($_SESSION['id']))
        {
            $id_user = $_SESSION['id'];
            $login = $_SESSION['login'];
        }
        else
        {
            $id_user = 0;
            $login = 'Аноним';
        }
    ?>
    <div class="form_input_revie">
    <form id="form">
        <lable>Пишите от имени: <?php echo $login; ?></lable><br>
        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>"><br> 
        <textarea name="text_comment" cols="50" rows="2" maxlength="200"></textarea><br>
        
        <?php
            if($id_user != 0)
            {
                $result = $mysqli->query("SELECT score FROM review WHERE id_user = $id_user"); // нельзя с 1 пользователя ставить много оценок
                $row = mysqli_fetch_array($result);
                
                echo    'Выберите оценку:
                        <select id="score">';
                
                for($i = 1; $i <= 5; $i++)
                {
                    if($row['score'] == $i || $i == 5) // ищем оценку, которую уже ставил пользователь (или по-умолчанию ставим 5))))
                    {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>'; 
                        $i++;
                        while($i != 6)
                        {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                            $i++;
                        }
                        break;
                    }
                    else
                    {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                echo    '</select><br>';
            }
            else
            {
                echo '<input type="hidden" id="score" value="0">';
            }
        ?>
        <input type="button" id="button" value="Отправить"><span id="err"></span>
    </form>  </div>
    <div id="comments"></div>
   
</body>
</html>