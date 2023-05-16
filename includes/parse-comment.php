<?php
$feedback = '';
$feedback_class = '';
//if the form was submitted
if(isset( $_POST['did_comment']) ){
    //sanatize every field
    $body = strip_tags(strip_tags($POST['body']));
    //validate
    //if valid,add the comment to the DB
if($body == '' OR strlen($body) > 200  ){
    $valid = false;
}
if($valid) {
    $result =$DB->prepare('INSERT INTO comments
    (user_id, date, body, post_id,is_approved)
    VALUES
    (?, NOW(), :body, :post, 1 )');
    //@Togo
    $result->execute ( array
    'user' => 1,
    'body' => $body,
    'post' => $post_id,
));

//chseck if it worked
if($result->rowCount()){
    //sucsee
    $feedback = 'Thank you for your comment';
    $feedback_class='success';
}else{
    //insert errror
$feedback = 'Sorry, your comment could not be saved.';
}$feedback_class = 'error';
}else{
    //not valid
    $feedback = 'Invalid Comment try again.'
}
}
