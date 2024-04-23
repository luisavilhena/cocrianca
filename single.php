<?php

get_header(); ?>
<?php while (have_posts()) : the_post(); ?>

<main id="blog-single" class="structure-container">
	<div class="structure-container__all-content structure-container__side">
		<div class="blog-single__header">
			<div class="blog-single__header">
				<h1><?php the_title(); ?></h1>
				<div><?php the_excerpt();?></div>
				<div>
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
					<div>
						<p>Escrito por: <?php the_author(); ?></p>
						<p><?php the_author_meta( 'description' ); ?></p>
					</div>

					<?php echo do_shortcode('[publishpress_authors_box layout="boxed"]')?>
				</div>
				<?php ?>
			</div>
		</div>
	</div>
	<div class="blog-single__img"style="background-image:url('<?php the_post_thumbnail_url("image_desktop_full_no_crop") ?>');">
	</div>
	<div class="structure-container__content structure-container__side ">
		<div class="blog-single__info">
			<?php 
			setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
			date_default_timezone_set('America/Sao_Paulo');
			echo 'Publicado em '.strftime(' %d de %B de %Y', strtotime('today')); ?>
			</br>
			por <?php echo do_shortcode('[publishpress_authors_data field="display_name"]')?>
		</div>
		<div class="blog_content">
			<?php the_content(); ?>
		</div>
	</div>
	<div class="blog-contact">
		<div>
			<h3>Quer ser colunista do nosso portal?</h3>
			<h3>Mande um e-mail para:</h3>
			<a href="mailto:contato@cocrianca.com.br">contato@cocrianca.com.br</a>
			<h4>Escreva também para fazer sugestões ou reportar erro na nossa edição!</h4>
		</div>
		
	</div>
	<div class="structure-container__content structure-container__side">
		<h2>leia outros artigos</h2>
		<div class="cards-list">
		<?php 
			$get_posts_blog = get_posts([
				'taxonomy' => 'post',
				'order'  => 'desc',
				'posts_per_page' => 6,
			]);
			$latest_cpt = get_posts("post_type=post&numberposts=1");
			$Id= $latest_cpt[0]->ID;
			foreach ($get_posts_blog as $key => $value) {
				$postId = $value->ID;
				$url=get_permalink($value->ID);
				$tags=get_the_tags($value->ID);
				$thumbnail= get_the_post_thumbnail($value->ID, 'horizontal-c');
				$title=$value->post_title;
				if($Id == $postId){

				} else {
					echo '
					<a class="cards-list__item cards-list__item--special" href="'.$url.'">
						<div class="image-columns__item__img">'.
							$thumbnail.'
						</div>
						<div class="cards-list__item-text">';
						if($tags){
							foreach($tags as $tag) {
	    					echo 
	    					'<h5>'.
	    					$tag->name . ' </h5>'; 
	  					}
						}
	  				echo '
							<h4>'.$title .'</h4>
						</div>
					</a>';
				}
			}
		?>
		</div>
	</div>
</main>
<?php endwhile; ?>

<?php
get_footer();