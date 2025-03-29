<?php 
get_header(); 
page_banner([
  'title' => 'All Programs',
  'subtitle' => 'There is something for everyone. Have a look at our programs.'
]);
?>

<div class="container container--narrow page-section"> 
<br>
<ul class="link-list min-list">
<?php
while(have_posts()) {
    the_post(); ?>
       <li><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a> </li>

<?php }
echo paginate_links();
?>
</ul>
</div>

<?php get_footer(); ?>