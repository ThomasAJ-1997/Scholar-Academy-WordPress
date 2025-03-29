<?php 
get_header();
page_banner([
  'title' => 'All Events',
  'subtitle' => 'See the world and what is going on.'
]);
?>

<div class="container container--narrow page-section"> 
<br>
<?php
while(have_posts()) {
    the_post();
    get_template_part('template-parts/content-event'); 
 }
echo paginate_links();
?>
<hr class="section-break">
<p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events here.</a></p>
</div>

<?php get_footer(); ?>