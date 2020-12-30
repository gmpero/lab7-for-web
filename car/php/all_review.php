<?php 
    //session_start();
    require_once("bdconnect.php");
    if(isset($_POST['id_brand']))
    {   
        $result_review = $mysqli->prepare("SELECT text, score, id_user FROM review WHERE id_brand = ?");
        $result_user = $mysqli->prepare("SELECT login FROM user WHERE id = ?");
        
        $result_review->bind_param("i", $_POST['id_brand']);
        $result_review->execute();
        
        $total = $result_review->get_result();

        while($row_review = $total->fetch_assoc())
        {
            $result_user->bind_param("i", $row_review['id_user']);
            $result_user->execute();
            $login = $result_user->get_result()->fetch_assoc();
            echo
                '<div>
                    <p class="name_user">'.$login['login'].'</p> <!--имя-->
                    <p class="mark">Оценка: '.$row_review['score'].'</p><!--оценка-->
                    <p class="text"> '.$row_review['text'].'</p> <!--текст-->
                    
                </div>';
        }
        $result_user->close();
        $result_review->close();
    }
?>