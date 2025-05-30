<?php get_header();

while(have_posts()) {
    the_post();
    page_banner();
    ?>
    
    <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i>All Campuses</a> <span class="metabox__main">
          <?php the_title(); ?>
          </span>
        </p>
      </div>

        <div class="generic-content"><?php the_content(); ?></div>

        <div class="acf-map">
<?php $mapLocation = get_field('map_location'); ?>
    <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" 
    data-lng="<?php echo $mapLocation['lng']; ?>">
    <h3><?php the_title(); ?> </h3>
    <?php echo $mapLocation['address'] ?>    
        </div>
</div>

        <?php 
         $related_programs = new WP_Query([
          'posts_per_page' => -1,
          'post_type' => 'program',
          'orderby' => 'title',
          'order' => 'ASC',
          'meta_query' => [
              [
                'key' => 'related_campus',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"',
              ],
          ],
      ]); 

      if ($related_programs->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium"> Programs Available at this campus </h2>';
        echo '<ul class="min-list link-list">';
        while($related_programs->have_posts()) {
            $related_programs->the_post(); ?>
            <li>
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?>
              </a></li>
        <?php }
        echo '</ul>';
      }

      wp_reset_postdata(); 
      // Resets the global post object and all data back to the default URL based query.
      // If you run mulitple queries on one page, you need this method so the custom queries don't clash. 
      //////////////////////////////////////////////////////////////////////////////////

      $today = date('Ymd');
      $events_homepage = new WP_Query([
          'posts_per_page' => 2,
          'post_type' => 'event',
          'meta_key' => 'event_date',
          'orderby' => 'meta_value_num',
          'order' => 'ASC',
          'meta_query' => [
                        [
                            'key' => 'event_date',
                            'compare' => '>=',
                            'value' => $today,
                            'type' => 'numeric',
                        ],
                        [
                          'key' => 'related_programs',
                          'compare' => 'LIKE',
                          'value' => '"' . get_the_ID() . '"',
                        ],
                    ],
                ]); 

                if ($events_homepage->have_posts()) {
                  echo '<hr class="section-break">';
                  echo '<h2 class="headline headline--medium">Upcoming ' .get_the_title() . ' Events</h2>';
                  
                  while($events_homepage->have_posts()) {
                      $events_homepage->the_post(); 
                      get_template_part('template-parts/content-event');
                     
                 }
                }

                ?>

        
<?php  } ?>


<?php  get_footer()  ?>
