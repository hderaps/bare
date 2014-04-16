<?php get_header(); ?>
  <div id="content">
    <div id="inner-content" class="container clear">
        <div id="main" class="col col-8 mobile-full" role="main">
          <?php woocommerce_content(); ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
  </div>
<?php get_footer(); ?>
