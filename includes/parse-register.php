<?php 
$errors =array();
$feedback = '';
$feedback_class = '';
//if the user submitted the register form
if(isset($_POST['did_register']) ){
    //sanitize eveything 
    $username = trim(strip_tags($_POST['username']));
    $email =filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $password = trim(strip_tags($_POST['password']));
    if(isset($_POST['policy']) ){
        $policy = 1;

    }else{
        $poliy = 0;
    }
    //validate
    $valid = true;
    //if valid add the user to the DB
    if( strlen($password) < 8 ){
        $valid = false;
        $errors['username'] = 'Password must be at least 8 characters long';
    }
    //username test
    if( strlen($username) < 5 OR strlen($username) > 30 ){
        $valid = false;
        $errors['username'] = 'Your username must be between 5-10 characters long.';
    }else{
        //checcl ifnameis already taken. look this username up in the DB
        $result =$DB->prepare('SELECT username FROM users
        WHERE username =?
        LIMIT 1');


        $result->execute( array( $username ) );
        //check it
        if ( $result->rowCount() ){
            //name is taken
            $valid = false;
            $errors['username'] = 'That username is already taken. Try another.';
        }
    }//end user name test
if(! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
    $valid = false;
    $errors['email'] = 'Provide a valid email address.';
}else{
    //Lok up this enail in the DB
    $result = $DB->prepare('SELECT email FROM users
    WHERE email = ?
    LIMIT 1');
    $result->execute( array($email) );
    if($result->rowCount()){
        $valid = false;
        $errors['email'] = 'Your email is already regostere. Try logging in.';
    }
}

if( ! $policy ){
$valid = false;
$eerrors['policy'] = ' You must agree to our terms before signing up';
}
//if valid,add the user to the DB
if( $valid){
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $result = $DB->prepare('INSERT INTO users
    (username, profile_pic, password, email, bio, is_admin, join_date)
    VALUES
    (:username, :pic, :pass, :email, :bio, 0,NOW())');
    $result->execute(array(
        'username' => $username,
        'pic' => '',
        'pass' => $hashed_pass,
        'email' =>$email,
        'bio' => '',
    ));
    if($result->rowCount()){
        $feedback = 'welcome! you are now a member of Finsta. Go log in!';
    }else{
        $feedback = 'something went wrong when adding yoru account. Try again';
    
    }
}else{
    $feedback ='Your registration is incomplete. fix the following:';
    $feedback_class = 'error';
}





  
}
