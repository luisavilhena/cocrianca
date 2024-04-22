<?php

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<main id="page-default" class="structure-container">
  <div class="structure-container__all-content">
  	<div>
  	<?php
  		get_breadcrumb();
  		the_content(); 
	?>  		
  	</div>
  </div>
</main>
<?php endwhile; ?>

<?php
get_footer();

