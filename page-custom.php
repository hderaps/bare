<?php
/*
Template Name: Custom Page Example
*/
?>

<?php get_header(); ?>

			<div id="content">
				<div id="inner-content" class="container">
						<div id="main" class="col eight mobile-full" role="main">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
								<header class="article-header">
									<h1 class="page-title"><?php the_title(); ?></h1>
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>.', 'baretheme' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'baretheme' ) ), bare_get_the_author_posts_link() );
									?></p>
								</header>

								<section class="entry-content section" itemprop="articleBody">
									<?php the_content(); ?>
								</section>

								<footer class="article-footer">
									<p class="clearfix"><?php the_tags( '<span class="tags">' . __( 'Tags:', 'baretheme' ) . '</span> ', ', ', '' ); ?></p>
								</footer>
								<?php comments_template(); ?>
							</article>
							<?php endwhile; else : ?>
									<article id="post-not-found" class="hentry section">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'baretheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'baretheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the page-custom.php template.', 'baretheme' ); ?></p>
										</footer>
									</article>
							<?php endif; ?>
						</div>
						<?php get_sidebar(); ?>
				</div>
			</div>

<?php get_footer(); ?>
