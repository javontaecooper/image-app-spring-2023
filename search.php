<?php require( 'config.php' ); 
require_once( 'includes/functions.php' );
require( 'includes/header.php' );

//search DATA
$per_page = 10;

$current_page = 1;


//if there is a page in the query string use it!
if(isset($_GET['page'])){
    $current_page = filter_var( $_GET['page'], FILTER_SANITITZE_NUMBER_INT );
}


if(isset($_GET['phrase']) ){
    $phrase = trim( strip_tags( $_GET['phrase']));
}else{
    $phrase = '';
}
require( 'includes/header.php');
?>
		<main class="content">
			<div class="posts-container flex one two-600 three-900">
				<?php 
				//get all the matching published posts
                //1. write it
                $query = 'SELECT * FROM posts 
                WHERE is_published = 1
                AND
                (title LIKE :phrase
                OR body LIKE :phrase)
                ORDER BY date DESC';
				$result = $DB->prepare($query); 

				//2. run it (execute)
				$result->execute(array('phrase' => "%$phrase%" ));
                $total = $result->rowCount();
                //how many pages will it take?
                $max_pages = ceil( $total / $per_page);

                if($current_page <1 OR $current_page > $max_pages){
                    $current_page = 1;
                }

$offset = ($current_page -1) * $per_page;
$query .= ' LIMIT :offset, :per_page';
//runit again
$result = $DB->prepare( $query );
//bind the datatupes corretlu (limit requires int)
$wildcards = "%$phrase%";
$result->bindParam( 'phrase', $wildcards, PDO::PARAM_STR );
$result->bindParam( 'offset', $offset, PDO::PARAM_INT );
$result->bindParam( 'per_page', $per_page, PDO::PARAM_INT );
//rin it again
$result->execute();
// debug_statement($result);
?>
                <section class="full">
                            <h2>Search Results for <?php echo $phrase;?></h2>
                            <h3>
                                <?php echo $total; ?> post found.<br> showing page <?php  echo $current_page;
                                ?> of <?php echo $max_pages; ?></h3>
                    </section>
				<?php
				if( $result->rowCount() ){
				
					while( $row = $result->fetch() ){
						//print_r($row);
						
						?>
                        
						<article class="post">
							<div class="card">
								<div class="post-image-header">
									<a href="single.php?post_id=<?phpecho $row['post_id']; ?>">
										<img src="<?php echo $row['image']; ?>" alt='<?php echo $row['title']; ?>' class='post-image'>
									</a>
								</div> 
								<footer>
									
									<h3 class="post-title clamp"><?php echo $row['title']; ?></h3>
									<p class="post-excerpt clamp"><?php echo $row['body']; ?></p>
									<div class="flex post-info">							
										<span class="date"><?php echo time_ago($row['date']); ?></span>	
										<span class="comment-count"><?php echo count_comments($row['post_id'] ); ?>
									</span>	
										
								
									</div>
								</footer>
							</div><!-- .card -->
						</article> <!-- .post -->
						<?php 
			} //end while
            ?>
            <section class="pagination full">
                <?php
                //pagination variables
                $prev = $current_page -1;
                $next = $current_page + 1;
                
                if( $current_page > 1 ){ ?>

               
                <a class="button"href="search.php?phrase<?php echo $phrase; ?>&amp;pages=<?php echo $prev; ?>">&larr; Previous</a>
                <?php }

                if($current_page < $max_pages){ ?>
                <a class="button"href="search.php?phrase<?php echo $phrase; ?>&amp;pages=<?php echo $next;?>">NEXT&rarr; </a>
                <?php } ?>
            </section>
            <?php
		}else{
			echo '<h2>No posts to show</h2>';
		} 
		?>

	</div><!-- .posts-container -->
</main>
	
<?php 
require( 'includes/sidebar.php' );
require( 'includes/footer.php' );
?>