<?php
    require_once("bdconnect.php");

    $id_user = $_POST['id_user'];
    $review =  $_POST['review'];
    $score =  $_POST['score'];
    $id_brand = $_POST['id_brand'];

    $result = $mysqli->prepare("INSERT INTO review (id_user, text, score, id_brand) VALUES (?, ?, ?, ?)");
    $result->bind_param("isii", $_POST['id_user'], $_POST['review'], $_POST['score'], $_POST['id_brand']);
    $result->execute();
?>