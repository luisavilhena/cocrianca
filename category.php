<?php



get_header(); ?>

<?php 
$args = array( 
	'post_type' => 'projetos', 
	'posts_per_page' => -1 );
$the_query = new WP_Query( $args ); 
?>
	<div id="category" class="structure-container">
		<div class="structure-container__content structure-container__side">
			<div class="cards-list">
				 <?php $terms = get_terms(array(
				 		'taxonomy'=>'projeto',
				 		'hide_empty' => 'false'
				 )) ?>
			    <?php foreach ( $terms as $term ) : ?>
			        <a href="/<?= esc_attr( $term->slug ) ?>">
			             <?php echo $term->name ?>
			        </a>
			    <?php endforeach; ?>
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
