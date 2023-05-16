<?php 
//template fo a single post
require( 'config.php' ); 
require_once( 'includes/functions.php' );

//get the ID of THISpost
//URL will be single.php?post_id=x
//validate and sanitize
$post_id =0;
if(isset($_GET['post_id'])){
    $post_id = filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT);

    if($post_id <= 0){
        $post_id = 0;
    }
}
// parse the form before the doctype
require( 'includes/parse-comment.php');
require( 'includes/header.php' );
?>
		<main class="content"> 
            <?php //Get all the info about THIS post
            
      $result = $DB->prepare('SELECT posts.*, categories.*, users.username, users.profile_pic
      FROM posts, users, categories
      WHERE posts.user_id = users.user_id
      AND posts.category_id = categories.category_id
      AND posts.is_published = 1
      ORDER BY posts.date DESC
      LIMIT 1');    
      $result->execute( array( $post_id ) );
      //checkit
      if( $result->rowCount() ){
        //loopit
        while( $row = $result->fetch() ){  ?>
<article class="post">
    <div class="card flex one two-700">
    <div class="post-image-header two-third-700"></div>
    <img src="<?php echo $row['image']; ?>" alt='<?php echo $row['title']; ?>' class='post-image'>
IMAGE
    </div>
<footer class="third-700">
<?php user_info($row['user_id'], $row['username'], $row['profile_pic'] ); ?>
    USER
<h3><?php echo $row['title']; ?></h3>
<p><?php echo $row['body']; ?><BODY</p>
</footer>
</article>
<?php 
}
$allow_comments = $row['allow_comments'];
//load the comments on this post
require('includes/comments.php');
      if($allow_comments ){
require('includes/comment-form.php;');
      
 }else{
    echo '<h2>Post not found</h2>';
}?>

        </main>
		<?php	
require( 'includes/sidebar.php' );
require( 'includes/footer.php' );
?>