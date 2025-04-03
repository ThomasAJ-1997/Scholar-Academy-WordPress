<?php

function page_banner($args = NULL) {
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
      }

      if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
      } 

      if (!isset($args['photo'])) {
        if (get_field('page_banner_background_image')) {
          $args['photo'] = get_field('page_banner_background_image')['sizes']['page_banner'];
        } else {
          $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php 
      echo $args['photo'] ?>"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle'] ?></p>
        </div>
      </div>
    </div>

<?php }

function scholar_academy_files() {
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyBtC8wRGKnkMkrk8LnIGegI5yNi0ddmhcE', null, '1.0', true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('academy_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('academy_extra_styles', get_theme_file_uri('/build/index.css'));
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}

add_action('wp_enqueue_scripts', 'scholar_academy_files');
// First argument is the type of action we want to do, for example load a file.
// Second argument is the name of a function we want to run: we create this function.

function scholar_academy_features() {
    add_theme_support('title-tag');
    add_theme_support( 'post-thumbnails', array( 'professor' ));
    add_image_size('professor_landscape', 400, 260, true);
    add_image_size('professor_portrait', 480, 650, true);
    add_image_size('page_banner', 1500, 350, true);
};

add_action('after_setup_theme', 'scholar_academy_features');
// If you want to change the top level of the website: got to the settings general in the admin panel.

// Adjust Custom Queries
function scholar_academy_adjust_queries($query) {
  if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
    $query->set('posts_per_page', -1);

} 
  
  if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);

    }

   if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
    $today = date('Ymd');
    
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', [
        [
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric',
        ],
    ],
);

   }
}

add_action('pre_get_posts', 'scholar_academy_adjust_queries');

function scholar_academy_map_key($api) {
  $api['key'] = 'AIzaSyBtC8wRGKnkMkrk8LnIGegI5yNi0ddmhcE';
  return $api;
} 
add_filter('acf/fields/google_map/api', 'scholar_academy_map_key');