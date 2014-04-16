<?php get_header(); ?>
  <div id="content">
    <div id="inner-content" class="container clear">
      <div id="main" class="col col-8 mobile-full" role="main">
          <?php if (is_category()) { ?>
            <h1 class="archive-title h2">
              <span><?php _e( 'Posts Categorized:', 'baretheme' ); ?></span> <?php single_cat_title(); ?>
            </h1>
          <?php } elseif (is_tag()) { ?>
            <h1 class="archive-title h2">
              <span><?php _e( 'Posts Tagged:', 'baretheme' ); ?></span> <?php single_tag_title(); ?>
            </h1>
          <?php } elseif (is_author()) {
            global $post;
            $author_id = $post->post_author;
          ?>
            <h1 class="archive-title h2">
              <span><?php _e( 'Posts By:', 'baretheme' ); ?></span> <?php the_author_meta('display_name', $author_id); ?>
            </h1>
          <?php } elseif (is_day()) { ?>
            <h1 class="archive-title h2">
              <span><?php _e( 'Daily Archives:', 'baretheme' ); ?></span> <?php the_time('l, F j, Y'); ?>
            </h1>
          <?php } elseif (is_month()) { ?>
            <h1 class="archive-title h2">
              <span><?php _e( 'Monthly Archives:', 'baretheme' ); ?></span> <?php the_time('F Y'); ?>
            </h1>
          <?php } elseif (is_year()) { ?>
            <h1 class="archive-title h2">
              <span><?php _e( 'Yearly Archives:', 'baretheme' ); ?></span> <?php the_time('Y'); ?>
            </h1>
          <?php } ?>
          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'clear' ); ?> role="article">
              <header class="article-header">
                <h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                <p class="byline vcard"><?php
                  printf(__( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'baretheme' ), get_the_time('Y-m-j'), get_the_time(__( 'F jS, Y', 'baretheme' )), bare_get_the_author_posts_link(), get_the_category_list(', '));
                ?></p>
              </header>
              <section class="entry-content section">
                <?php the_post_thumbnail( 'bare-thumb-300' ); ?>
                <?php the_excerpt(); ?>
              </section>
              <footer class="article-footer">
              </footer>
            </article>
          <?php endwhile; ?>
            <?php if ( function_exists( 'bare_page_navi' ) ) { ?>
              <?php bare_page_navi(); ?>
            <?php } else { ?>
              <nav class="wp-prev-next">
                <ul class="clear">
                  <li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'baretheme' )) ?></li>
                  <li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'baretheme' )) ?></li>
                </ul>
              </nav>
            <?php } ?>
          <?php else : ?>
            <article id="post-not-found" class="hentry clear">
              <header class="article-header">
                <h1><?php _e( 'Oops, Post Not Found!', 'baretheme' ); ?></h1>
              </header>
              <section class="entry-content">
                <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'baretheme' ); ?></p>
              </section>
              <footer class="article-footer">
                <p><?php _e( 'This is the error message in the archive.php template.', 'baretheme' ); ?></p>
              </footer>
            </article>
          <?php endif; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
  </div>
<?php get_footer(); ?>
