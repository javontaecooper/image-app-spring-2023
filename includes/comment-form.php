<section class="comment-form">
<h2>Leave a coment</h2>
<form action="single.php?post_id=x" <?php echo $post_id; ?>method="post">
<label>Your Comment</label>
<textarea name="body" id="thebody"></textarea>
<input type="submit" value="Comment">
<input type="hidden" name="did_comment" value="1">
</form>
</section>