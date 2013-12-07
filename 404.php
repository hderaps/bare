<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="container">

						<div id="main" class="col eight mobile-full" role="main">

						<article id="post-not-found" class="hentry section">

							<header class="article-header">

								<h1><?php _e( 'Epic 404 - Article Not Found', 'baretheme' ); ?></h1>

							</header>

							<section class="entry-content">

								<p><?php _e( 'The article you were looking for was not found, but maybe try looking again!', 'baretheme' ); ?></p>

							</section>

							<section class="search">

									<p><?php get_search_form(); ?></p>

							</section>

							<footer class="article-footer">

									<p><?php _e( 'This is the 404.php template.', 'baretheme' ); ?></p>

							</footer>

						</article>

					</div>

				</div>

			</div>

<?php get_footer(); ?>
