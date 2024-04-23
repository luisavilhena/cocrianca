<?php

get_header(); ?>

<?php if (have_posts()) : the_post(); ?>

<main id="page-default page" class="structure-container">
  <div class="structure-container__all-content">
  	<div>
  	<?php
  		get_breadcrumb();
  		the_content(); 
	?>  		
  	</div>
  </div>
</main>
<?php endif; ?>

<?php
get_footer();