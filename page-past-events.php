<?php 
get_header(); 
page_banner([
    'title' => 'Past Events',
    'subtitle' => 'A recap on our past events.'
  ]);
?>

<div class="container container--narrow page-section"> 
<br>
<?php

$today = date('Ymd');
$past_events_query = new WP_Query([
    'paged' => get_query_var('paged', 1),
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => [
        [
            'key' => 'event_date',
            'compare' => '<',
            'value' => $today,
            'type' => 'numeric',
        ],
    ],
]); 

while($past_events_query->have_posts()) {
    $past_events_query->the_post(); 
    get_template_part('template-parts/content-event');
 }
echo paginate_links([
    'total' => $past_events_query->max_num_pages, 
    ''
]);
?>


</div>

<?php get_footer(); ?>