<?php
get_header();

// Seção para recuperar as informações da taxonomia (termos)
$current_url = home_url( add_query_arg( array(), $wp->request ) ); 
$url_array = explode('/',$current_url);
$retVal = !empty($url_array[5]) ? $url_array[5] : $url_array[4] ;
$idObj = get_category_by_slug($retVal);

// Argumentos da consulta para ambas as seções
$args = array(
    'post_type'      => 'projetos',
    'posts_per_page' => -1,
);

// Consulta para a seção da taxonomia
if ($retVal) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'projeto',
            'field'    => 'slug',
            'terms'    => $retVal,
        )
    );
}

// Consulta para a seção do arquivo de projetos
$the_query = new WP_Query( $args ); 
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$new_link = str_replace('projetos','projeto', $actual_link);
$correct_link = explode('projeto', $new_link);
$link = $correct_link[0];
?>

<div class="structure-container">
    <div class="carousel">
        <div id="carousel-img">
            <div class="item" style="background-image: url('<?php echo get_template_directory_uri() ?>/resources/8.jpg');">
            </div>				
        </div>
        <div class="carousel-text">
            <p>experiências coletivas de</p>
            <h1>projeto, construção e aprendizagem</h1>
        </div>
    </div>
    <div class="structure-container__content structure-container__side">
        <div class="filter">
            <?php 
            // Seção da taxonomia
            if ($retVal) {
                $terms = get_terms('projeto', array(
                    'orderby'=> 'id',
                    'order' => 'ASC',
                ));
                foreach ( $terms as $term ) {
                    $class = ( strstr( $_SERVER['REQUEST_URI'], $term->slug ) !== false ) ? 'page-active' : '';
                    echo '<a href="' . $link . '/projeto/' . esc_attr( $term->slug ) . '" class="' . esc_attr( $class ) . '"><h3>' . esc_html( $term->name ) . '</h3></a>';
                }
            }
            ?>
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
