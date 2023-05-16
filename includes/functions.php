<?php
// make date stamps human readable
function nice_date( $timestamp ){
    $date = new DateTime($timestamp);
    return $date->format('l, F jS Y');

}


//no close php


//convert timestamp to amount of timeago 1day ago

function time_ago($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


//cout the comments on any post
function count_comments($post_id){
    //use the database connection from theglobal scope
    global $DB;
    $result = $DB->prepare('SELECT COUNT(*) AS total
                            FROM comments
                            WHERE post_id = ?
                            AND is_approved = 1');
//pass avaraible to the placeholder in the query(?)
 $result->execute( array( $post_id ));
 if( $result->rowCount() ){
    while($row = $result->fetch() ){
        return $row['total'];
    }//end while
 }//endif
}//end function count_comments

//show user info (profile pic and username)
function user_info($id,  $username,   $profile_pic = 'avatars/default.png'){
//check if the profile ic exits
if($profile_pic == ''){
    $profile_pic = 'avatars/default.png';
}
?>
<div class="user">
    <a href="#">
<img src="<?php echo $profile_pic; ?>" alt="<?php echo $username; ?>'s
 width="50" height="50" class="profile-pic">
<span><?php echo $username;?></span>
</a>
</div>
<?php
}
//no close php
/**
 * Display the HTML feedback element for basic forms
 * @param  string $heading the H2 content
 * @param  array  $list    the list of issues to fix
 * @param  string $class   either "success" or "error"
 * @return mixed          HTML element
 */
function show_feedback( $heading, $class = 'error', $list = array()  ){
    if( isset( $heading ) AND $heading != '' ){
        echo "<div class='feedback $class'>";
        echo "<h2>$heading</h2>";
        //if the list is not empty, show it is a <ul>
        if( ! empty( $list ) ){
            echo '<ul>';
            foreach( $list as $item ){
                echo "<li>$item</li>";
            }
            echo '</ul>';
        }
        echo '</div>';
    }
}
    /**
* displays sql query information including the computed parameters.
* Silent unless DEBUG MODE is set to 1 in CONFIG.php
* @param [statement handler] $sth -  any PDO statement handler that needs troubleshooting
*/
function debug_statement($sth){
    if( DEBUG_MODE ){
        echo '<pre class="full">';
        $info = debug_backtrace();
        echo '<b>Debugger ran from ' . $info[0]['file'] . ' on line ' . $info[0]['line'] . '</b><br><br>';
        $sth->debugDumpParams();
        echo '</pre>';
    }
}







