<?php
    session_start();
    require_once("bdconnect.php");

    /*
    $display = '';
    if(isset($_SESSION['id']) && $_SESSION['id'] == 1) // дисплей дли администратора
    {
        $result_brand = $mysqli->query("SELECT * FROM `brand` ORDER BY brand");
        
        while($row_brand = $result_brand->fetch_assoc())
        {
            switch($row_brand['wheel_drive'])
            {
                case 1: $wheel_drive = 'Переднеприводный'; break;
                case 2: $wheel_drive = 'Заднеприводный'; break;
                case 3: $wheel_drive = 'Полноприводный'; break;
            }
            
            $display .=
                '<div class="table">
                    <img src="php/'.$row_brand['img_path'].'" alt="*Здесь должно быть фото*" height="100" width="150">
                    <table>
                        <tr>
                            <th><h2>'.$row_brand['brand'].'</h2></th>

                            <th>
                                 <form action="form_edit_brand.php" method="post">
                                     <input type="hidden" name="id_brand" value="'.$row_brand['id_brand'].'">
                                     <input type="submit" value="Редактировать" name="submit_brand" class="button">
                                </form>
                            </th>
                            <th>
                                <form action="php/delete_brand.php" method="post">
                                    <input type="hidden" name="id_brand" value="'.$row_brand['id_brand'].'">
                                    <input type="submit" value="Удалить" name="submit_brand" class="button_delete">
                                </form>
                            </th>
                        </tr>
                    </table>
                    <p class="info_about_auto">Информация о этой марке: <br>
                        Привод - '.$wheel_drive.'
                        <br>
                        Число пассажиров - '.$row_brand['number_of_passengers'].' <br>
                        Вместимость багажника - '.$row_brand['trunk_volume'].' литров <br>
                    </p>

                    <h3>Вот что у нас есть:</h3><br>

                    <table>
                        <tr><th class="name_car">Цена</th><th class="name_car">Год выпуска</th></tr>';
                    
                    $result_car = $mysqli->query("SELECT * FROM `car` WHERE id_brand = ". $row_brand['id_brand']); 

                    while ($row_car = $result_car->fetch_assoc())
                    {
                        $display.=
                        '<tr>
                            <th>'.$row_car['car_cost'].'</th>
                            <th>'.$row_car['release_date'].'</th>
                            <th>
                                <form action="form_edit_car.php" method="post">
                                    <input type="hidden" name="id_car" value="'.$row_car['id_car'].'">
                                    <input type="submit" value="Редактировать" name="submit_car" class="button">
                                </form>
                            </th>
                            <th>
                                <form action="php/delete_car.php" method="post">
                                    <input type="hidden" name="id_car" value="'.$row_car['id_car'].'">
                                    <input type="submit" value="Удалить" name="submit_car" class="button_delete">
                                </form>
                            </th>
                        </tr>'; 
                    }
            $display.='</table></div>';
        }
        echo $display;
    }
    */



    $result_brand = $mysqli->query("SELECT * FROM `brand` ORDER BY brand"); // по-сути только 1 раз запрос делаем
    
    $result_car = $mysqli->prepare("SELECT * FROM car WHERE id_brand = ?"); // проще взять всё через *
    $result_engine = $mysqli->prepare("SELECT id_factory, title, power FROM engine WHERE id_configuration = ?");
    $result_salon = $mysqli->prepare("SELECT address, work_schedule FROM salon WHERE id_salon = ?");
    $result_factory = $mysqli->prepare("SELECT title, address FROM factory WHERE id_factory = ?");


    while($row_brand = $result_brand->fetch_assoc())
    {
        switch($row_brand['wheel_drive'])
        {
            case 1: $wheel_drive = 'Переднеприводный'; break;
            case 2: $wheel_drive = 'Заднеприводный'; break;
            case 3: $wheel_drive = 'Полноприводный'; break;
        }
        
        $result_configuration = $mysqli->prepare("SELECT * FROM configuration WHERE id_brand = ?"); // 2 разных будем обращения делать к этой базе

        echo
            '<div class="table">
                <table>
                    <tr>
                        <th><h2>'.$row_brand['brand'].'</h2></th>
                        <td class="text_feedback">';

                if(isset($row_brand['average_score'])) // средняя оценка пользователей
                {
                    echo 'Оценка по отзывам: <form action="review.php" method="post"><input type="hidden" name="id_brand" value="'.$row_brand['id_brand'].'"><input type="submit" value="'.$row_brand['average_score'].'"></form>';
                }
                else
                {
                    echo 'Оставить отзыв: <form action="review.php" method="post"><input type="hidden" name="id_brand" value="'.$row_brand['id_brand'].'"><input type="submit" value="Отправить/прочитать"></form>';
                }

        echo            '</td>
                    </tr>
                </table>

              

              <div class="info_car">
                <p class="info_about_auto">Информация о этой марке: <br>
                    Привод - '.$wheel_drive.'
                    <br>
                    Число пассажиров - '.$row_brand['number_of_passengers'].' <br>
                    Вместимость багажника - '.$row_brand['trunk_volume'].' литров <br>
                </p>
                </div>
                <div class="img_car">
                <img src="php/'.$row_brand['img_path'].'" alt="*Здесь должно быть фото*" height="200" width="300">
                </div>

                <div class="f"> <h4>Комплектации:</h4>
                ';

        $result_configuration->bind_param("i", $row_brand['id_brand']);
        $result_configuration->execute();
        
        $total_configuration = $result_configuration->get_result();
        echo '<table cellspacing="2" cellpadding="" border="1" width="100% class="table_complate"><tr><th>Название</th><th>Описание</th><th>Название</th><th>Мощность (в л.с.)</th><th>Название</th><th>Адрес</th></tr>';
        
        while($row_configuration = $total_configuration->fetch_assoc())
        {
            echo '<tr><td>'.$row_configuration['title'].'</td><td>'.str_replace("\n", "<br>", $row_configuration['description']).'</td>';
            
            $result_engine->bind_param("i", $row_configuration['id_configuration']);
            $result_engine->execute();
            
            if($row_engine = $result_engine->get_result()->fetch_assoc())
            {
                echo '<td>'.$row_engine['title'].'</td><td>'.$row_engine['power'].'</td>';
            }
            else
            {
                echo '<td>Не указано</td><td>Не указано</td>';
            }
            
            
            $result_factory->bind_param("i", $row_engine['id_factory']);
            $result_factory->execute();
            
            if($row_factory = $result_factory->get_result()->fetch_assoc())
            {
                echo '<td>'.$row_factory['title'].'</td><td>'.$row_factory['address'].'</td>';
            }
            else
            {
                echo '<td>Не указано</td><td>Не указано</td>';
            }
            
            echo '</tr>';
        }
        
        $result_configuration->close();
        
        echo '</table> </div> <br>';
       
                
        echo '<h3>Вот что есть из авто:</h3><br>';
        echo  '<table  class="table_adress">
                    <tr><th class="cell">Цена</th><th class="cell">Год выпуска</th><th class="cell">Комплектация</th><th class="cell">Адрес</th><th class="cell">График работы</th></tr>';

        
        
        $result_car->bind_param("i", $row_brand['id_brand']); // формируем
        $result_car->execute(); // отправляем
        $total_car = $result_car->get_result(); // получаем весь итог запроса
        

        $result_configuration = $mysqli->prepare("SELECT title FROM configuration WHERE id_configuration = ?");

        while ($row_car = $total_car->fetch_assoc()) //берём по строке-массиву
        {   
         echo
            '<tr>
                <td>'.$row_car['car_cost'].'</td>
                <td>'.$row_car['release_date'].'</td>';

            $result_configuration->bind_param("i", $row_car['id_configuration']);
            $result_configuration->execute();

            if($row_configuration = $result_configuration->get_result()->fetch_assoc())
            {
                echo '<td>'.$row_configuration['title'].'</td>';
            }
            else
            {
                echo '<td>Не указано</td>';
            }


            $result_salon->bind_param("i", $row_car['id_salon']);
            $result_salon->execute();

            if($row_salon = $result_salon->get_result()->fetch_assoc())
            {
        echo   '<td>'.$row_salon['address'].'</td>
                <td>'.$row_salon['work_schedule'].'</td>'; 
            }
            else
            {
        echo   '<td>Не указано</td>
                <td>Не указано</td>';    
            }

            echo '</tr>';
        }
        $result_configuration->close();
        
        echo '</table></div>';
        
    }
        $result_car->close();
        $result_engine->close();
        $result_salon->close();
        $result_factory->close();
?>