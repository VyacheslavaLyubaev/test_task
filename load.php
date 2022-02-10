<?php
include 'connect_db.php';
$post_url    = 'https://jsonplaceholder.typicode.com/posts';
$post_data   = file_get_contents($post_url);
if (!empty($post_data)) {
    $contents = json_decode(html_entity_decode($post_data), TRUE);
    $insert = "INSERT INTO post (userId, id, title, body) VALUES";
    foreach ($contents as $content)
    {
        $userId = $content["userId"];
        $post_id = $content["id"];
        $post_title = $content["title"];
        $post_body = $content["body"];

        $post_value = $post_value." ($userId,$post_id,'$post_title','$post_body'),";
    }
    $post_sql = $insert.trim($post_value,',').';';
    if (mysqli_query($conn, $post_sql)) {
        $num_post = mysqli_affected_rows($conn);
    } else {
        echo "Error: " . $post_sql . "<br>" . mysqli_error($conn);
    }
}

$comments_url    = 'https://jsonplaceholder.typicode.com/comments';
$comments_data   = file_get_contents($comments_url);
if (!empty($comments_data)) {
    $contents = json_decode(html_entity_decode($comments_data), TRUE);
    $insert = "INSERT INTO comment (postId, id, name, email, body) VALUES";
    foreach ($contents as $content)
    {
        $postId = $content["postId"];
        $comments_id = $content["id"];
        $comments_name = $content["name"];
        $comments_email = $content["email"];
        $comments_body = $content["body"];
        $comments_value = $comments_value." ($postId, $comments_id,'$comments_name','$comments_email','$comments_body'),";
    }
    $comments_sql = $insert.trim($comments_value,',').';';
    if (mysqli_query($conn, $comments_sql)) {
        $num_comments = mysqli_affected_rows($conn);
    } else {
        echo "Error: " . $comments_sql . "<br>" . mysqli_error($conn);
    }
}
print "Загружено $num_post записей и $num_comments комментариев";
mysqli_close($conn);