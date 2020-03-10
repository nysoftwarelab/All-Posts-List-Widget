<?php

/**
 * All Posts Widget.
 */
class All_Posts_List_Widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        $widget_options = array(
            'classname' => 'aplw_widget all-posts-list',
            'description' => __('A widget that gives you total control over the output of your sites most post list.', 'APLW_TEXT_DOMAIN'),
            'customize_selective_refresh' => true,
        );

        parent::__construct(
            'all_posts_list_widget', // Base ID
            esc_html__('All Posts List Widget', 'APLW_TEXT_DOMAIN'), // Name
            array('description' => esc_html__('An All Posts List Widget', 'APLW_TEXT_DOMAIN')) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        //echo '<pre>';
        //print_r($instance);
        //echo '</pre>';
        if (empty( $instance['title_html_tag'] )){  $instance['title_html_tag'] = "h1"; }
        if (empty( $instance['posts_per_page'] )){  $instance['posts_per_page'] = 6; }
        if (empty( $instance['columns'] )){ $instance['columns']=3; }
        if (empty( $instance['order_by'] )){ $instance['order_by']="date"; }
        if (empty( $instance['order'] )){ $instance['order']="ASC"; }
        
        $paged = 1;
        if ( get_query_var( 'paged' ) ) { 
            $paged = get_query_var( 'paged' ); 
        } elseif ( get_query_var( 'page' ) ) { 
            $paged = get_query_var( 'page' ); 
        } else { 
            $paged = 1; 
        }
        $offset = ($paged -1)*intval($instance['posts_per_page']);

        $args = array(
            'post__in' => ($instance['specific_posts']) ? explode(',', $instance['specific_posts']) : false,
            'post_type' => $instance['specific_type'],
            'posts_per_page' => $instance['posts_per_page'],
            'category__in' => $instance['specific_cats'],
            'tag_slug__in' => ($instance['specific_tags']) ? explode(',', $instance['specific_tags']) : false,
            'meta_key' => (strlen($instance['acf'])>0) ? $instance['acf'] : false,
            'orderby' => $instance['order_by'],
            'order'   => $instance['order'],
            'paded' => $paged,
            'offset'=> $offset,
        );
        $wp_posts = new WP_Query($args);

        $slug = basename(get_permalink());

        if ($instance['columns']>0){
            $columns = " aplw-columns-".$instance['columns'];
        }else{
            $columns="";
        }

        // ======================================================= Start
        if (isset($args['before_widget'])){ echo $args['before_widget']; }
        
        echo '<div class="aplw-page-' . $slug . $columns.'">';

        while ($wp_posts->have_posts()): $wp_posts->the_post();

            $ID = get_the_ID();
            $link = get_permalink();
            $cat = get_the_category();
            $cat_css = "";
            foreach ($cat as $k => $v) {$cat_css .= "category-" . $v->slug . " ";}
            $status_css = "status-" . get_post_status();
            $title = get_the_title();
            $type_css = 'type-'.$instance['specific_type'];
            if (get_post_format()) {
                $format_css = 'format-' . get_post_format();
            } else {
                $format_css = 'format-standard';
            }
            $tags = get_the_tags();
            $comments = get_comments_number($ID);
            
            //print_r($tags);
            $is_flex = "";
            if ($instance['featured_inline']=="aplw-inline"){ $is_flex="aplw-grid-item-flex"; }

            $meta_block = $this->aplw_buildMetaBlock($link,
                $instance,
                get_day_link(get_the_date("Y"), get_the_date("m"), get_the_date("d")),
                get_the_date(),
                get_author_posts_url(get_the_author_meta('ID')),
                get_the_author(),
                $cat,
                $tags,
                $comments
            );
             
            ?>
            <div class="aplw-grid-item aplw-post-item <?php echo $is_flex." post-" . $ID . " " . $type_css . " " . $format_css . " " . $status_css . " " . $cat_css; ?>">
                <div class="aplw-frame">
                    <?php if ($instance['featured_image'] != "none") {
                        if ( has_post_thumbnail()){
                            $th_id = get_post_thumbnail_id();
                            $th_url = get_the_post_thumbnail_url();
                            $alt = get_post_meta($th_id, '_wp_attachment_image_alt', true);
                            $srcset = wp_get_attachment_image_srcset($th_id);
                            ?>
                            <!-- featured image box -->
                            <div class="aplw-post-image-wrap <?php echo $instance['featured_image_percent']." ".$instance['featured_inline']; ?>">
                                <a class="aplw-post-image-link" href="<?php echo get_permalink(); ?>">
                                    <?php the_post_thumbnail($instance['featured_image']); ?>
                                    <span class="aplw-post-image-overlay"></span>
                                </a>
                            </div><?php
                        }
                    }?>
                
                    <div class="aplw-post-content <?php echo $instance['featured_inline']; ?>">
                        <?php if ($instance['meta_pos'] == "Before Title") {echo $meta_block;}?> <!-- Meta tag box / before title -->
                        <<?php echo $instance['title_html_tag'].' class="aplw-post-title '.$instance['title_align'].'"'; ?>> <!-- Title -->
                            <a class="aplw-post-title-link" href="<?php echo get_permalink(); ?>"><?php echo $title; ?></a>
                        </<?php echo $instance['title_html_tag']; ?>>
                        <?php if ($instance['meta_pos'] == "After Title") {echo $meta_block;}?> <!-- Meta tag box / after title -->
                        <?php if ($instance['show_excer']) {?> <!-- Excerpt -->
                            <div class="aplw-post-excerpt <?php echo $instance['meta_align']; ?>">
                                <?php echo get_the_excerpt(); ?>
                            </div>
                        <?php }?>

                        <?php if ($instance['meta_pos'] == "After Excerpt") {echo $meta_block;}?> <!-- Meta tag box / after excerpt -->
                        <?php if ($instance['show_button']) {?> <!-- Button -->
                            <div class="alpw-post-read-more <?php echo $instance['button_align']; ?>">
                                <a class="alpw-post-button" href="<?php echo get_permalink(); ?>">
                                    <span class="alpw-post-button-text"><?php echo $instance['button_text']; ?></span>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
        <?php
        endwhile;
        wp_reset_postdata();

        echo '</div>';
        if (isset($args['after_widget'])){ echo $args['after_widget']; }
        
        // ======================================================= End
    }
    
    public function aplw_explodeBetween ($d1, $d2, $text){
        $ret = array();
        $rm = "";
        $alphas = explode($d1, $text);
        foreach ($alphas as $k => $v) {
            if ($k>0){
                $p2 = mb_strpos($v, $d2);
                $rt = mb_substr($v, 0, $p2);
                $rm = $d1.$rt.$d2;
                $exp = explode($rm,$text);
                $ret = array ($exp[0], $rt, $exp[1]);
            }
        }
        
        return $ret;
    }
    
    public function aplw_buildMetaBlock($link, $instance, $date_link = '', $date_text = '', $author_link = '', $author = '', $cat = null, $tags = null, $comments = 0)
    {
        $firstBuilded = false;
        $ret = '<div class="aplw-post-meta '.$instance['meta_align'].'">';
        if ($instance['show_date']) {
            
            //print_r(preg_split("/({|})/", $instance['show_date_format']));
            //print_r($this->aplw_explodeBetween("{","}",$instance['show_date_format']));
            $frmt = $this->aplw_explodeBetween("{","}",$instance['show_date_format']);
            $date_text = $frmt[0].date($frmt[1], strtotime($date_text)).$frmt[2];
            
            $ret .= '<a class="aplw-post-meta-item aplw-post-meta-date" href="' . $date_link . '" rel="bookmark">' . $date_text . '</a>';
            $firstBuilded = true;
        }
        if ($instance['show_author']) {
            if ($firstBuilded){ $ret .= '<span class="aplw-post-meta-divider"> / </span>'; }
            $ret .= '<a class="aplw-post-meta-item aplw-post-meta-author" href="' . $author_link . '" rel="bookmark">' . $author . '</a>';
            $firstBuilded = true;
        }
        if ($instance['show_categ']) {
            if ($cat) {
                if ($firstBuilded){ $ret .= '<span class="aplw-post-meta-divider"> / </span>'; }
                foreach ($cat as $k => $v) {
                    //print_r($v);
                    $ret .= '<a class="aplw-post-meta-item aplw-post-meta-cat" href="' . get_category_link($v->term_id) . '" rel="bookmark">' . $v->name . '</a>, ';
                }
                $ret = substr($ret, 0, strlen($ret) - 2);
                $firstBuilded = true;
            }
        }
        if ($instance['show_tags']) {
            if ($tags) {
                if ($firstBuilded){ $ret .= '<span class="aplw-post-meta-divider"> / </span>'; }
                foreach ($tags as $k => $v) {
                    //print_r($v);
                    $ret .= '<a class="aplw-post-meta-item aplw-post-meta-tag" href="' . get_tag_link($v->term_id) . '" rel="bookmark">' . $v->name . '</a>, ';
                }
                $firstBuilded = true;
            }
        }
        if ($instance['show_comm']) {
            if ($firstBuilded){ $ret .= '<span class="aplw-post-meta-divider"> / </span>'; }
            if ($comments == 0) {
                $ret .= '<a class="aplw-post-meta-item aplw-post-meta-tag" href="' . $link . '#comments" rel="bookmark">No Comments</a>, ';
            } else {
                $ret .= '<a class="aplw-post-meta-item aplw-post-meta-tag" href="' . $link . '#comments" rel="bookmark">(' . $comments . ') Comments</a>, ';
            }
        }

        $ret .= '</div>';

        return $ret;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        include APLW_CLASS . 'form.php';
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        //$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['specific_posts'] = (!empty($new_instance['specific_posts'])) ? sanitize_text_field($new_instance['specific_posts']) : '';
        $instance['specific_tags'] = (!empty($new_instance['specific_tags'])) ? sanitize_text_field($new_instance['specific_tags']) : '';
        $instance['specific_cats'] = $new_instance['specific_cats'];
        $instance['specific_type'] = (!empty($new_instance['specific_type'])) ? $new_instance['specific_type'] : 'post';
        
        $instance['columns'] = (!empty($new_instance['columns'])) ? $new_instance['columns'] : '3';
        $instance['posts_per_page'] = (!empty($new_instance['posts_per_page'])) ? $new_instance['posts_per_page'] : '6';
        $instance['title_html_tag'] = (!empty($new_instance['title_html_tag'])) ? $new_instance['title_html_tag'] : 'h1';
        $instance['title_align'] = (!empty($new_instance['title_align'])) ? $new_instance['title_align'] : 'left';
        
        $instance['featured_image'] = (!empty($new_instance['featured_image'])) ? $new_instance['featured_image'] : 'none';
        $instance['featured_image_percent'] = (!empty($new_instance['featured_image_percent'])) ? $new_instance['featured_image_percent'] : 'aplw-width-100';
        $instance['featured_inline'] = (!empty($new_instance['featured_inline'])) ? $new_instance['featured_inline'] : 'aplw-block';
        
        $instance['meta_pos'] = (!empty($new_instance['meta_pos'])) ? $new_instance['meta_pos'] : 'After Title';
        $instance['meta_align'] = (!empty($new_instance['meta_align'])) ? $new_instance['meta_align'] : 'left';

        $instance['show_date'] = (!empty($new_instance['show_date'])) ? (bool) $new_instance['show_date'] : false;
        $instance['show_date_format'] = (!empty($new_instance['show_date_format'])) ? $new_instance['show_date_format'] : 'Date : {F j, Y}';
        
        $instance['show_author'] = (!empty($new_instance['show_author'])) ? (bool) $new_instance['show_author'] : false;
        $instance['show_categ'] = (!empty($new_instance['show_categ'])) ? (bool) $new_instance['show_categ'] : false;
        $instance['show_tags'] = (!empty($new_instance['show_tags'])) ? (bool) $new_instance['show_tags'] : false;
        $instance['show_comm'] = (!empty($new_instance['show_comm'])) ? (bool) $new_instance['show_comm'] : false;
        
        $instance['show_excer'] = (!empty($new_instance['show_excer'])) ? (bool) $new_instance['show_excer'] : false;
        $instance['excer_align'] = (!empty($new_instance['excer_align'])) ? $new_instance['excer_align'] : 'left';

        $instance['show_button'] = (!empty($new_instance['show_button'])) ? (bool) $new_instance['show_button'] : false;
        $instance['button_align'] = (!empty($new_instance['button_align'])) ? $new_instance['button_align'] : 'left';
        $instance['button_text'] = (!empty($new_instance['button_text'])) ? sanitize_text_field($new_instance['button_text']) : '';

        $instance['order_by'] = (!empty($new_instance['order_by'])) ? $new_instance['order_by'] : 'date';
        $instance['order'] = (!empty($new_instance['order'])) ? $new_instance['order'] : 'ASC';
        $instance['acf'] = (!empty($new_instance['acf'])) ? sanitize_text_field($new_instance['acf']) : '';

        return $instance;
    }

} // class All_Posts_List_Widget

function aplw_cats_list()
{

    // Arguments
    $args = array('number' => 99);

    // Allow dev to filter the arguments
    $args = apply_filters('aplw_cats_list_args', $args);

    // Get the cats
    $cats = get_terms('category', $args);

    return $cats;

}

function aplw_post_types()
{

    // Arguments
    $args = array();

    // Allow dev to filter the arguments
    $args = apply_filters('aplw_post_list_args', $args);

    // Get the cats
    $posts = get_post_types($args);// get_terms('category', $args);
    
    return $posts;

}