<?php require('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Finsta - Image Sharing</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picnic">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="icon" type="image/x-icon" sizes="32x32" href="favicon.ico">
</head>
<body>
	<div class="site">
		<header class="header">
			<nav>
				<a href="index.php" class="brand">
					<img class="logo" src="images/logo-color.png" />
					<span>Finsta</span>
				</a>				
			</nav>
		</header>
		<main class="content">
			<div class="posts-container flex one two-600 three-900">
				<?php 
				//get all the published posts from the DB
				//1. write it (prepare the statement)
				$result = $DB->prepare('SELECT image, title, body, date 
										FROM posts
										WHERE is_published = 1'); 
				//2. run it (execute)
				$result->execute();

				//3. check it (were any posts found?)
				if( $result->rowCount() ){
				//4. loop it
					while( $row = $result->fetch() ){
						//print_r($row);
						?>
						<article class="post">
							<div class="card">
								<div class="post-image-header">
									<a href="#">
										<img src="<?php echo $row['image']; ?>" alt='<?php echo $row['title']; ?>' class='post-image'>
									</a>
								</div>
								<footer>
									<h3 class="post-title clamp"><?php echo $row['title']; ?></h3>
									<p class="post-excerpt clamp"><?php echo $row['body']; ?></p>
									<div class="flex post-info">							
										<span class="date"><?php echo $row['date']; ?></span>			
									</div>
								</footer>
							</div><!-- .card -->
						</article> <!-- .post -->
						<?php 
			} //end while
		}else{
			echo '<h2>No posts to show</h2>';
		} 
		?>

	</div><!-- .posts-container -->
</main>
<aside class="sidebar flex grow one two-500 three-800">
	<?php 
	$result = $DB->prepare('SELECT username 
							FROM users
							WHERE is_admin = 0
							LIMIT 5');
	$result->execute();
	if( $result->rowCount() ){ ?>
	<section class="users">
		<h2>Newest Users</h2>
		<?php while( $row = $result->fetch() ){ ?>
		<a href="#">
			<img class="profile-pic" src="avatars/default.png" alt="USERNAME" width="50" height="50">
			USERNAME
		</a>
		<?php } //end while ?>

	</section>
	<?php } //end users ?>

	<?php 
	$result = $DB->prepare('SELECT * FROM categories LIMIT 20');
	$result->execute();
	if( $result->rowCount() ){ ?>
	<section class="categories">
		<h2>Categories</h2>
		<?php while ( $row = $result->fetch() ) { ?>
		<a href='#' class='pseudo button'><?php echo $row['name']; ?> (NUM)</a> 
		<?php } ?>

	</section>
	<section class="meta">
		<h2>Fine Print</h2>
		<div>
			<a href="#" class="pseudo button">Terms of Service</a>
			<a href="#" class="pseudo button">About Finsta</a>
			<a href="#" class="pseudo button">Contact</a>
		</div>
	</section>
</aside>		
<footer class="footer">&copy; 2023 Finsta</footer>
</div>
</body>
</html>