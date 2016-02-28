	<?php
/*
Template Name: Portfolio Grid
*/
?>
	<div id="pageheader" class="titleclass">
		<div class="container">
			<?php get_template_part('templates/page', 'header'); ?>
		</div><!--container-->
	</div><!--titleclass-->
	
    <div id="content" class="container">
   		<div class="row">
      		<div class="main <?php echo bigcloudcms_main_class(); ?>" id="ktmain" role="main">
      	  	<?php if ( ! post_password_required() ) { ?>
				<div class="entry-content" itemprop="mainContentOfPage">
					<?php get_template_part('templates/content', 'page'); ?>
				</div>
      			<?php 
      			global $post, $bigcloudcms_premium; 
      			
      			if(isset($bigcloudcms_premium['bigcloudcms_animate_in']) && $bigcloudcms_premium['bigcloudcms_animate_in'] == 1) {
      				$animate = 1;
      			} else {
      				$animate = 0;
      			}
      			$portfolio_category = get_post_meta( $post->ID, '_kad_portfolio_type', true );
			   	$portfolio_items = get_post_meta( $post->ID, '_kad_portfolio_items', true );
			   	$portfolio_order = get_post_meta( $post->ID, '_kad_portfolio_order', true );
			   	$portfolio_filter = get_post_meta( $post->ID, '_kad_portfolio_filter', true );
			   	$portfolio_column = get_post_meta( $post->ID, '_kad_portfolio_columns', true );
			   	$portfolio_item_excerpt = get_post_meta( $post->ID, '_kad_portfolio_item_excerpt', true );
			   	$portfolio_item_types = get_post_meta( $post->ID, '_kad_portfolio_item_types', true );
			   	$portfolio_cropheight = get_post_meta( $post->ID, '_kad_portfolio_img_crop', true );
			   	$portfolio_crop = get_post_meta( $post->ID, '_kad_portfolio_crop', true );
			   	$portfolio_lightbox = get_post_meta( $post->ID, '_kad_portfolio_lightbox', true );

			   	if(isset($portfolio_order)) {
			   		$p_orderby = $portfolio_order;
			   	} else {
			   		$p_orderby = 'menu_order';
			   	}
			   	if($p_orderby == 'menu_order' || $p_orderby == 'title') {$p_order = 'ASC';} else {$p_order = 'DESC';}
				
				if($portfolio_category == '-1' || empty($portfolio_category)) {
					$portfolio_cat_slug = ''; $portfolio_cat_ID = ''; 
				} else {
					$portfolio_cat = get_term_by ('id',$portfolio_category,'portfolio-type' );
					$portfolio_cat_slug = $portfolio_cat -> slug;
					$portfolio_cat_ID = $portfolio_cat -> term_id;
				}
				$portfolio_category = $portfolio_cat_slug;
				if($portfolio_items == 'all') { 
					$portfolio_items = '-1'; 
				}

	  			if ($portfolio_filter == 'yes') { ?>
		      		<section id="options" class="clearfix">
						<?php 
						if(!empty($bigcloudcms_premium['filter_all_text'])) {$alltext = $bigcloudcms_premium['filter_all_text'];} else {$alltext = __('All', 'bigcloudcms');}
						if(!empty($bigcloudcms_premium['portfolio_filter_text'])) {$portfoliofiltertext = $bigcloudcms_premium['portfolio_filter_text'];} else {$portfoliofiltertext = __('Filter Projects', 'bigcloudcms');}
							$termtypes = array( 'child_of' => $portfolio_cat_ID,);
							$categories= get_terms('portfolio-type', $termtypes);
							$count = count($categories);
								echo '<a class="filter-trigger headerfont" data-toggle="collapse" data-target=".filter-collapse"><i class="icon-tags"></i> '.$portfoliofiltertext.'</a>';
								echo '<ul id="filters" class="clearfix option-set filter-collapse">';
								echo '<li class="postclass"><a href="#" data-filter="*" title="All" class="selected"><h5>'.$alltext.'</h5><div class="arrow-up"></div></a></li>';
								 if ( $count > 0 ){
									foreach ($categories as $category){ 
									$termname = strtolower($category->slug);
									$termname = preg_replace("/[^a-zA-Z 0-9]+/", " ", $termname);
									$termname = str_replace(' ', '-', $termname);
									echo '<li class="postclass kt-filter-'.esc_attr($termname).'"><a href="#" data-filter=".'.esc_attr($termname).'" title="" rel="'.esc_attr($termname).'"><h5>'.$category->name.'</h5><div class="arrow-up"></div></a></li>';
										}
						 		}
						 		echo "</ul>"; ?>
					</section>
		        <?php } 
                
		        if ($portfolio_column == '2') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $slidewidth = 560; $slideheight = 560;} 
		        else if ($portfolio_column == '3'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 366; $slideheight = 366;} 
		        else if ($portfolio_column == '1'){ $itemsize = 'tcol-md-12 tcol-sm-12 tcol-xs-12 tcol-ss-12'; $slidewidth = 1140; $slideheight = 1140;} 
		        else if ($portfolio_column == '6'){ $itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240; } 
		        else if ($portfolio_column == '5'){ $itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6'; $slidewidth = 240; $slideheight = 240;} 
		       	else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 270; $slideheight = 270;}
		        
		        $crop = true;
		        if (!empty($portfolio_cropheight)){
		        	$slideheight = $portfolio_cropheight; 
		        } 
		        if ($portfolio_crop == 'no'){ $slideheight = ''; $crop = false; } 
                
                if ($portfolio_lightbox == 'yes'){
                	$plb = 'true';
                } else {
            		$plb = 'false';
            	}
            	if($portfolio_item_excerpt == true) {
            			$showexcerpt = 'true';
            	} else {
            		$showexcerpt = 'false';
            	}
            	if($portfolio_item_types == true) {
            			$portfolio_item_types = 'true';
				} else {
					$portfolio_item_types = 'false';
				}

            	global $kt_portfolio_loop;
                 $kt_portfolio_loop = array(
                 	'lightbox' => $plb,
                 	'showexcerpt' => $showexcerpt,
                 	'showtypes' => $portfolio_item_types,
                 	'slidewidth' => $slidewidth,
                 	'slideheight' => $slideheight,
                 	);
                 	?>

               <div id="portfoliowrapper" class="init-isotope rowtight" data-fade-in="<?php echo esc_attr($animate);?>" data-iso-selector=".p-item" data-iso-style="masonry" data-iso-filter="true"> 
   
            <?php 
				$temp = $wp_query; 
				  $wp_query = null; 
				  $wp_query = new WP_Query();
				  $wp_query->query(array(
					'paged' => $paged,
					'orderby' => $p_orderby,
					'order' => $p_order,
					'post_type' => 'portfolio',
					'portfolio-type'=>$portfolio_cat_slug,
					'posts_per_page' => $portfolio_items
					)
				  );
					
					if ( $wp_query ) : 
							 
					while ( $wp_query->have_posts() ) : $wp_query->the_post();
						$terms = get_the_terms( $post->ID, 'portfolio-type' );
						if ( $terms && ! is_wp_error( $terms ) ) : 
							$links = array();
								foreach ( $terms as $term ) { $links[] = $term->slug;}
							$links = preg_replace("/[^a-zA-Z 0-9]+/", " ", $links);
							$links = str_replace(' ', '-', $links);	
							$tax = join( " ", $links );		
						else :	
							$tax = '';	
						endif;
						?>
					<div class="<?php echo esc_attr($itemsize); ?> <?php echo strtolower($tax); ?> all p-item">
                	<?php do_action('bigcloudcms_portfolio_loop_start');
							get_template_part('templates/content', 'loop-portfolio'); 
						  do_action('bigcloudcms_portfolio_loop_end');
					?>
                    </div>
					<?php endwhile; else: ?>
					 
					<li class="error-not-found"><?php _e('Sorry, no portfolio entries found.', 'bigcloudcms');?></li>
						
				<?php endif; ?>
                </div> <!--portfoliowrapper-->
                                    
                    <?php if ($wp_query->max_num_pages > 1) : 
                            kad_wp_pagenavi();   
                    	  endif; 

                    $wp_query = null; 
                    $wp_query = $temp;  // Reset
                    wp_reset_query(); ?>

                    <?php global $bigcloudcms_premium; if(isset($bigcloudcms_premium['page_comments']) && $bigcloudcms_premium['page_comments'] == '1') { comments_template('/templates/comments.php');} ?>

<?php } else { ?>
      <?php echo get_the_password_form();
    }?>

</div><!-- /.main -->