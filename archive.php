<?php
    get_header();
    $get_posts_blog = get_posts([
        'taxonomy' => 'post',
        'order'  => 'desc',
        'posts_per_page' => 6,
    ]);
    $the_query = new WP_Query( $args ); 
?>

<main id="blog-list" class="structure-container">
    <div class="structure-container__all-content structure-container__side">
        <?php
            $latest_cpt = get_posts("post_type=post&numberposts=1");
            $Id= $latest_cpt[0]->ID;
            $Title= get_the_title($Id);
            $Excerpt= get_the_excerpt($Id);
            $Thumbnail=get_the_post_thumbnail($Id, 'horizontal-c');
            $Author= get_the_author($Id);	
            $Link = get_permalink($Id)			
        ?>
        <a href="<?php echo $Link;?>" class="blog-list__destak">
            <div class="blog-list__destak__img"><?php echo $Thumbnail;?></div>
            <div class="blog-list__destak__content">
                <h4>Colunista</h4>
                <h2><?php echo $Title;?></h2>
                <p><?php echo $Excerpt;?></p>
                <h3> por <?php echo $Author;?></h3>
            </div>
        </a>
        <h2>leia outros artigos</h2>
        <div class="cards-list">
        <?php 
            foreach ($the_query as $key => $value) {
                $postId = $value->ID;
                $url=get_permalink($value->ID);
                $tags=get_the_tags($value->ID);
                $thumbnail= get_the_post_thumbnail($value->ID, 'horizontal-c');
                $title=$value->post_title;
                if($postId==$Id){

                }else {
                    echo '
                    <a class="cards-list__item cards-list__item--special" href="'.$url.'">
                        <div class="image-columns__item__img">'.
                            $thumbnail.'
                        </div>
                        <div class="cards-list__item-text">';
                        if($tags){
                            foreach($tags as $tag) {
                            echo 
                            '<h5>'.$tag->name .' </h5>'; 
                        };
                        }
                    echo '	<h4>'.$title .'</h4>
                        </div>
                    </a>';
                }
            }
        ?>
        </div>
    </div>
    <?php the_content()?>
</main>


<?php
get_footer();