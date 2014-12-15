<?php get_header(); ?>
  <div id="content">
    <div id="inner-content" class="container clear">
      <div id="main" class="col col-8 mobile-full" role="main">
        <h1 class="archive-title"><span><?php _e( 'Search Results for:', 'baretheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class('section'); ?> role="article">
            <header class="article-header">
              <h3 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <p class="byline vcard"><?php
                printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'baretheme' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'baretheme' ) ), bare_get_the_author_posts_link(), get_the_category_list(', ') );
              ?></p>
            </header>
            <section class="entry-content">
                <?php the_excerpt( '<span class="read-more">' . __( 'Read more &raquo;', 'baretheme' ) . '</span>' ); ?>
            </section>
            <footer class="article-footer">
            </footer>
          </article>
        <?php endwhile; ?>
            <?php if (function_exists('bare_page_navi')) { ?>
              <?php bare_page_navi(); ?>
            <?php } else { ?>
              <nav class="wp-prev-next">
                <ul class="section">
                  <li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'baretheme' )) ?></li>
                  <li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'baretheme' )) ?></li>
                </ul>
              </nav>
            <?php } ?>
          <?php else : ?>
            <article id="post-not-found" class="hentry section">
              <header class="article-header">
                <h1><?php _e( 'Sorry, No Results.', 'baretheme' ); ?></h1>
              </header>
              <section class="entry-content">
                <p><?php _e( 'Try your search again.', 'baretheme' ); ?></p>
              </section>
              <footer class="article-footer">
                <p><?php _e( 'This is the error message in the search.php template.', 'baretheme' ); ?></p>
              </footer>
            </article>
          <?php endif; ?>
        </div>
        <?php get_sidebar(); ?>
      </div>
  </div>
<?php get_footer(); ?>
