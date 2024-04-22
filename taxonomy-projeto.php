<?php



get_header(); ?>

<?php
$current_url = home_url( add_query_arg( array(), $wp->request ) ); 
$url_array = explode('/',$current_url);
$retVal = !empty($url_array[5]) ? $url_array[5] : $url_array[4] ;
$idObj = get_category_by_slug($retVal);
$args = array(  'post_type' => 'projetos',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'projeto',
						'field' => 'slug',
						'terms' => $retVal,
					)
				) );
$the_query = new WP_Query( $args ); 
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$new_link = str_replace('projetos','projeto', $actual_link);
$correct_link = explode('projeto', $new_link);
$link = $correct_link[0];
?>
	<div  id="taxonomy-projeto"class="structure-container">
		<div class="carousel">
			<div id="carousel-img">
				<div class="item" style ="background-image: url('<?php echo get_template_directory_uri() ?>/resources/8.jpg');">
				</div>				
			</div>
			<div class="carousel-text">
				<p>
					expericências coletivas de
				</p>
				<h1>
					projeto, construção e aprendizagem
				</h1>
			</div>
		</div>
		<div class="structure-container__content structure-container__side">
			<div class="filter">
				<?php $terms = get_terms('projeto', array(
					'orderby'=> 'id',
					'order' => 'ASC',
				)) ?>
			    <?php foreach ( $terms as $term ) : ?>
			        <a href="<?php echo $link.'/projeto/'.esc_attr( $term->slug )?>">
			            <h3><?php echo $term->name ?></h3>
			        </a>
			    <?php endforeach; ?>
			  </div>
			<div class="cards-list">
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<a class="cards-list__item cards-list__item--special" href="<?php the_permalink(); ?>">
						<div class="image-columns__item__img">
							<?php the_post_thumbnail('horizontal-c');?>
						</div>
						<div class="cards-list__item-text">
							<h5><?php the_excerpt();?></h5>
							<h4><?php the_title();?></h4>
						</div>
					</a>
				<?php endwhile; ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>