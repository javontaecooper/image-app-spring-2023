<?php 
//get all the approved comments on this post
$result = $DB->prepare('SELECT comments. *, users..username, users.profile_pic
FROM comments, users
WHERE comments.user_id = users.user_id'
AND is_approved = 1
AND post_id = ?
ORDER by date DESC
LIMIT 30');
$result->execute( array( $post_id ) );
//are therr coments?
$total = $result->rowCount();
if ( $total ){                    
?>

<section class="comments">
    <h2><?php echo $total; ?> Comments on this post</h2>
<?php while( $row = $result->fetch() ){ ?>
    <div class="card">
        <footer>
            <?php user_info($row['user_id'], $row['date']); ?>

            <p><?php echo $row['body']; ?></p>
            <span class="date"><?php echo time_ago($row['date']); ?></span>
        </footer> 

    </div>
    <?php } ?>
</section>
<?php } ?>