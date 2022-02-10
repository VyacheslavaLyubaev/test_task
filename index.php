<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search</title>
</head>
<body>
    <form name = "search" method = "post" action = "index.php">
        <input type = "search" name = "query" placeholder = "Поиск">
        <button type = "submit">Найти</button>
    </form>
    <?php
    if (!empty($_POST['query'])) {
        $search_result = search($_POST['query']);
        echo $search_result;
    }
    ?>
</body>
</html>
<?php
function search($query){
    include 'connect_db.php';

    $query = trim($query);
    $query = htmlspecialchars($query);
    if (strlen($query) < 3){
        $text = '<p>Слишком короткий запрос</p>';
    }else {
        $sql = "SELECT p.title as t, c.body as b
                    from post p
                    join comment c on c.postId = p.id
                    where c.body LIKE '%$query%';";
        $res = mysqli_query($conn,$sql);

        if (mysqli_affected_rows($conn) > 0) {
            $text = '<p>По вашему запросу <b>'.$query.'</b> найдено: </p>';

            do{
                $row = mysqli_fetch_assoc($res);
                $text .= '<p><b>Заголовок записи:</b> '.$row["t"].'<br> <b>Комменатрий: </b>'.$row["b"].'</p>';
            }while($row = mysqli_fetch_assoc($res));

        } else {
            $text = '<p>По вашему запросу <b>'.$query.'</b> ничего не найдено: </p>';
        }
    }

    return $text;
}