<?php
//$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', APLW_TEXT_DOMAIN );
$specific_posts = !empty( $instance['specific_posts'] ) ? $instance['specific_posts'] : esc_html__( '', APLW_TEXT_DOMAIN );
$specific_tags = !empty( $instance['specific_tags'] ) ? $instance['specific_tags'] : esc_html__( '', APLW_TEXT_DOMAIN );
$specific_cats = !empty( $instance['specific_cats'] ) ? $instance['specific_cats'] : [];
$specific_type = !empty( $instance['specific_type'] ) ? $instance['specific_type'] : esc_html__( 'post', APLW_TEXT_DOMAIN );

$columns = !empty( $instance['columns'] ) ? $instance['columns'] : esc_html__( '3', APLW_TEXT_DOMAIN );
$posts_per_page = !empty( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : esc_html__( '6', APLW_TEXT_DOMAIN );
$title_html_tag = !empty( $instance['title_html_tag'] ) ? $instance['title_html_tag'] : esc_html__( 'h1', APLW_TEXT_DOMAIN );
$title_align = !empty( $instance['title_align'] ) ? $instance['title_align'] : esc_html__( 'aplw-left', APLW_TEXT_DOMAIN );

$featured_image = !empty( $instance['featured_image'] ) ? $instance['featured_image'] : esc_html__( 'none', APLW_TEXT_DOMAIN );
$featured_image_percent = !empty( $instance['featured_image_percent'] ) ? $instance['featured_image_percent'] : esc_html__( 'aplw-width-100', APLW_TEXT_DOMAIN );
$featured_inline = !empty( $instance['featured_inline'] ) ? $instance['featured_inline'] : esc_html__( 'aplw-block', APLW_TEXT_DOMAIN );

$meta_pos = !empty( $instance['meta_pos'] ) ? $instance['meta_pos'] : esc_html__( 'After Title', APLW_TEXT_DOMAIN );
$meta_align = !empty( $instance['meta_align'] ) ? $instance['meta_align'] : esc_html__( 'aplw-left', APLW_TEXT_DOMAIN );

$show_date = !empty( $instance['show_date'] ) ? $instance['show_date'] : false;
$show_author = !empty( $instance['show_author'] ) ? $instance['show_author'] : false;
$show_categ = !empty( $instance['show_categ'] ) ? $instance['show_categ'] : false;
$show_tags = !empty( $instance['show_tags'] ) ? $instance['show_tags'] : false;
$show_comm = !empty( $instance['show_comm'] ) ? $instance['show_comm'] : false;

$show_excer = !empty( $instance['show_excer'] ) ? $instance['show_excer'] : false;
$excer_align = !empty( $instance['excer_align'] ) ? $instance['excer_align'] : esc_html__( 'aplw-left', APLW_TEXT_DOMAIN );

$show_button = !empty( $instance['show_button'] ) ? $instance['show_button'] : false;
$button_align = !empty( $instance['button_align'] ) ? $instance['button_align'] : esc_html__( 'aplw-left', APLW_TEXT_DOMAIN );
$button_text = !empty( $instance['button_text'] ) ? $instance['button_text'] : esc_html__( 'Read More', APLW_TEXT_DOMAIN );

$order_by = !empty( $instance['order_by'] ) ? $instance['order_by'] : esc_html__( 'date', APLW_TEXT_DOMAIN );
$order = !empty( $instance['order'] ) ? $instance['order'] : esc_html__( 'ASC', APLW_TEXT_DOMAIN );
$acf = !empty( $instance['acf'] ) ? $instance['acf'] : esc_html__( '', APLW_TEXT_DOMAIN );

$default_image_sizes = get_intermediate_image_sizes();
$image_sizes = [];
foreach ( $default_image_sizes as $size ) {
    $image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
    $image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
    $image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
}
//print_r($image_sizes);

?>
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'specific_posts' ) ); ?>"><?php esc_attr_e( 'Specific Posts:', APLW_TEXT_DOMAIN ); ?></label>
    <input class="widefat" 
        id="<?php echo esc_attr( $this->get_field_id( 'specific_posts' ) ); ?>" 
        name="<?php echo esc_attr( $this->get_field_name( 'specific_posts' ) ); ?>" 
        type="text" 
        value="<?php echo esc_attr( $specific_posts ); ?>">
    <small class="italic">(limit to certain post IDs, use comma seperated values)</small>
</p>
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'specific_tags' ) ); ?>"><?php esc_attr_e( 'Specific Tags:', APLW_TEXT_DOMAIN ); ?></label>
    <input class="widefat" 
        id="<?php echo esc_attr( $this->get_field_id( 'specific_tags' ) ); ?>" 
        name="<?php echo esc_attr( $this->get_field_name( 'specific_tags' ) ); ?>" 
        type="text" 
        value="<?php echo esc_attr( $specific_tags ); ?>">
    <small class="italic">(limit to certain tags, use comma seperated values)</small>
</p>
<p>
    <label><?php _e( 'Limit to Category:', APLW_TEXT_DOMAIN ); ?></label>
    <ul class="aplw-check-list">
        <?php foreach ( aplw_cats_list() as $category ) : ?>
            <li>
                <input type="checkbox"
                    value="<?php echo (int) $category->term_id; ?>"
                    id="<?php echo $this->get_field_id( 'specific_cats' ) . '-' . (int) $category->term_id; ?>" 
                    name="<?php echo $this->get_field_name( 'specific_cats' ); ?>[]" 
                    <?php checked( is_array($specific_cats) && in_array( $category->term_id, $specific_cats ) ); ?> />
                    <label for="<?php echo $this->get_field_id( 'specific_cats' ) . '-' . (int) $category->term_id; ?>">
                        <?php echo esc_html( $category->name ); ?>
                    </label>
            </li>
        <?php endforeach; ?>
    </ul>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'specific_type' ); ?>"><?php esc_attr_e( 'Post Type:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'specific_type' ); ?>" name="<?php echo $this->get_field_name( 'specific_type' ); ?>" style="width:100%;">
        <?php foreach (aplw_post_types() as $k=>$ptype){?>
            <option value="<?php echo $k; ?>" <?php selected( $specific_type, $k ); ?>><?php echo $k; ?></option>
        <?php } ?>
    </select>
</p>
<hr/>
<p>
    <label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php esc_attr_e( 'Layout Columns:', APLW_TEXT_DOMAIN ); ?></label>
    <input class="widefat" 
        id="<?php echo $this->get_field_id( 'columns' ); ?>" 
        name="<?php echo $this->get_field_name( 'columns' ); ?>" 
        type="number" step="1" min="0" 
        value="<?php echo (int)( $columns ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php esc_attr_e( 'Posts Per Page:', APLW_TEXT_DOMAIN ); ?></label>
    <input class="widefat" 
        id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" 
        name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" 
        type="number" step="1" min="0" 
        value="<?php echo (int)( $posts_per_page ); ?>" />
</p>
<hr/>
<p>
    <label for="<?php echo $this->get_field_id( 'title_html_tag' ); ?>"><?php esc_attr_e( 'Title Html Tag:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'title_html_tag' ); ?>" name="<?php echo $this->get_field_name( 'title_html_tag' ); ?>" style="width:100%;">
        <option value="h1" <?php selected( $title_html_tag, 'h1' ); ?>><?php esc_attr_e( 'H1', APLW_TEXT_DOMAIN ) ?></option>
        <option value="h2" <?php selected( $title_html_tag, 'h2' ); ?>><?php esc_attr_e( 'H2', APLW_TEXT_DOMAIN ) ?></option>
        <option value="h3" <?php selected( $title_html_tag, 'h3' ); ?>><?php esc_attr_e( 'H3', APLW_TEXT_DOMAIN ) ?></option>
        <option value="h4" <?php selected( $title_html_tag, 'h4' ); ?>><?php esc_attr_e( 'H4', APLW_TEXT_DOMAIN ) ?></option>
        <option value="div" <?php selected( $title_html_tag, 'div' ); ?>><?php esc_attr_e( 'DIV', APLW_TEXT_DOMAIN ) ?></option>
        <option value="span" <?php selected( $title_html_tag, 'span' ); ?>><?php esc_attr_e( 'SPAN', APLW_TEXT_DOMAIN ) ?></option>
        <option value="p" <?php selected( $title_html_tag, 'p' ); ?>><?php esc_attr_e( 'P', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'title_align' ); ?>"><?php esc_attr_e( 'Title Align:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'title_align' ); ?>" name="<?php echo $this->get_field_name( 'title_align' ); ?>" style="width:100%;">
        <option value="aplw-left" <?php selected( $title_align, 'aplw-left' ); ?>><?php esc_attr_e( 'Left', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-center" <?php selected( $title_align, 'aplw-center' ); ?>><?php esc_attr_e( 'Center', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-right" <?php selected( $title_align, 'aplw-right' ); ?>><?php esc_attr_e( 'Right', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'featured_image' ); ?>"><?php esc_attr_e( 'Featured Image:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'featured_image' ); ?>" name="<?php echo $this->get_field_name( 'featured_image' ); ?>" style="width:100%;">
        <option value="none" <?php selected( $featured_image, 'none' ); ?>><?php esc_attr_e( 'None', APLW_TEXT_DOMAIN ) ?></option>
        <?php foreach ($image_sizes as $k=>$img){?>
            <option value="<?php echo $k; ?>" <?php selected( $featured_image, $k ); ?>><?php echo $k." (".$img['width']." X ".$img['height'].")"; ?></option>
        <?php } ?>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'featured_image_percent' ); ?>"><?php esc_attr_e( 'Featured Image Size:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'featured_image_percent' ); ?>" name="<?php echo $this->get_field_name( 'featured_image_percent' ); ?>" style="width:100%;">
        <option value="aplw-width-100" <?php selected( $featured_image_percent, 'aplw-width-100' ); ?>><?php esc_attr_e( '100%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-90" <?php selected( $featured_image_percent, 'aplw-width-90' ); ?>><?php esc_attr_e( '90%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-80" <?php selected( $featured_image_percent, 'aplw-width-80' ); ?>><?php esc_attr_e( '80%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-75" <?php selected( $featured_image_percent, 'aplw-width-75' ); ?>><?php esc_attr_e( '75%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-60" <?php selected( $featured_image_percent, 'aplw-width-60' ); ?>><?php esc_attr_e( '60%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-50" <?php selected( $featured_image_percent, 'aplw-width-50' ); ?>><?php esc_attr_e( '50%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-40" <?php selected( $featured_image_percent, 'aplw-width-40' ); ?>><?php esc_attr_e( '40%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-33" <?php selected( $featured_image_percent, 'aplw-width-33' ); ?>><?php esc_attr_e( '33%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-25" <?php selected( $featured_image_percent, 'aplw-width-25' ); ?>><?php esc_attr_e( '25%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-20" <?php selected( $featured_image_percent, 'aplw-width-20' ); ?>><?php esc_attr_e( '20%', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-width-10" <?php selected( $featured_image_percent, 'aplw-width-10' ); ?>><?php esc_attr_e( '10%', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'featured_inline' ); ?>"><?php esc_attr_e( 'Featured Image Inline:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'featured_inline' ); ?>" name="<?php echo $this->get_field_name( 'featured_inline' ); ?>" style="width:100%;">
        <option value="aplw-block" <?php selected( $featured_inline, 'aplw-block' ); ?>><?php esc_attr_e( 'Normal', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-inline" <?php selected( $featured_inline, 'aplw-inline' ); ?>><?php esc_attr_e( 'Inline', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-cell" <?php selected( $featured_inline, 'aplw-cell' ); ?>><?php esc_attr_e( 'Table Cell', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<hr/>
<p>
    <label for="<?php echo $this->get_field_id( 'meta_pos' ); ?>"><?php esc_attr_e( 'Meta tag possition:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'meta_pos' ); ?>" name="<?php echo $this->get_field_name( 'meta_pos' ); ?>" style="width:100%;">
        <option value="Before Title" <?php selected( $meta_pos, 'Before Title' ); ?>><?php esc_attr_e( 'Before Title', APLW_TEXT_DOMAIN ) ?></option>
        <option value="After Title" <?php selected( $meta_pos, 'After Title' ); ?>><?php esc_attr_e( 'After Title', APLW_TEXT_DOMAIN ) ?></option>
        <option value="After Excerpt" <?php selected( $meta_pos, 'After Excerpt' ); ?>><?php esc_attr_e( 'After Excerpt', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'meta_align' ); ?>"><?php esc_attr_e( 'Meta Box Align:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'meta_align' ); ?>" name="<?php echo $this->get_field_name( 'meta_align' ); ?>" style="width:100%;">
        <option value="aplw-left" <?php selected( $meta_align, 'aplw-left' ); ?>><?php esc_attr_e( 'Left', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-center" <?php selected( $meta_align, 'aplw-center' ); ?>><?php esc_attr_e( 'Center', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-right" <?php selected( $meta_align, 'aplw-right' ); ?>><?php esc_attr_e( 'Right', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<p>
    <input id="<?php echo $this->get_field_id( 'show_date' ); ?>" 
        name="<?php echo $this->get_field_name( 'show_date' ); ?>" 
        type="checkbox" <?php checked( $show_date ); ?> />
    <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show Date', APLW_TEXT_DOMAIN ); ?></label>
</p>
<p>
    <input id="<?php echo $this->get_field_id( 'show_author' ); ?>" 
        name="<?php echo $this->get_field_name( 'show_author' ); ?>" 
        type="checkbox" <?php checked( $show_author ); ?> />
    <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show Author', APLW_TEXT_DOMAIN ); ?></label>
</p>
<p>
    <input id="<?php echo $this->get_field_id( 'show_categ' ); ?>" 
        name="<?php echo $this->get_field_name( 'show_categ' ); ?>" 
        type="checkbox" <?php checked( $show_categ ); ?> />
    <label for="<?php echo $this->get_field_id( 'show_categ' ); ?>"><?php _e( 'Show Categories', APLW_TEXT_DOMAIN ); ?></label>
</p>
<p>
    <input id="<?php echo $this->get_field_id( 'show_tags' ); ?>" 
        name="<?php echo $this->get_field_name( 'show_tags' ); ?>" 
        type="checkbox" <?php checked( $show_tags ); ?> />
    <label for="<?php echo $this->get_field_id( 'show_tags' ); ?>"><?php _e( 'Show Tags', APLW_TEXT_DOMAIN ); ?></label>
</p>
<p>
    <input id="<?php echo $this->get_field_id( 'show_comm' ); ?>" 
        name="<?php echo $this->get_field_name( 'show_comm' ); ?>" 
        type="checkbox" <?php checked( $show_comm ); ?> />
    <label for="<?php echo $this->get_field_id( 'show_comm' ); ?>"><?php _e( 'Show Comments', APLW_TEXT_DOMAIN ); ?></label>
</p>
<hr/>
<p>
    <input id="<?php echo $this->get_field_id( 'show_excer' ); ?>" 
        name="<?php echo $this->get_field_name( 'show_excer' ); ?>" 
        type="checkbox" <?php checked( $show_excer ); ?> />
    <label for="<?php echo $this->get_field_id( 'show_excer' ); ?>"><?php _e( 'Show Exerpt', APLW_TEXT_DOMAIN ); ?></label>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'excer_align' ); ?>"><?php esc_attr_e( 'Excerpt Align:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'excer_align' ); ?>" name="<?php echo $this->get_field_name( 'excer_align' ); ?>" style="width:100%;">
        <option value="aplw-left" <?php selected( $excer_align, 'aplw-left' ); ?>><?php esc_attr_e( 'Left', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-center" <?php selected( $excer_align, 'aplw-center' ); ?>><?php esc_attr_e( 'Center', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-right" <?php selected( $excer_align, 'aplw-right' ); ?>><?php esc_attr_e( 'Right', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<p>
    <input id="<?php echo $this->get_field_id( 'show_button' ); ?>" 
        name="<?php echo $this->get_field_name( 'show_button' ); ?>" 
        type="checkbox" <?php checked( $show_button ); ?> />
    <label for="<?php echo $this->get_field_id( 'show_button' ); ?>"><?php _e( 'Show Button', APLW_TEXT_DOMAIN ); ?></label>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'button_align' ); ?>"><?php esc_attr_e( 'Button Align:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'button_align' ); ?>" name="<?php echo $this->get_field_name( 'button_align' ); ?>" style="width:100%;">
        <option value="aplw-left" <?php selected( $button_align, 'aplw-left' ); ?>><?php esc_attr_e( 'Left', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-center" <?php selected( $button_align, 'aplw-center' ); ?>><?php esc_attr_e( 'Center', APLW_TEXT_DOMAIN ) ?></option>
        <option value="aplw-right" <?php selected( $button_align, 'aplw-right' ); ?>><?php esc_attr_e( 'Right', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_attr_e( 'Button Text:', APLW_TEXT_DOMAIN ); ?></label> 
    <input class="widefat" 
        id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" 
        name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" 
        type="text" 
        value="<?php echo esc_attr( $button_text ); ?>">
</p>
<hr/>
<p>
    <label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php esc_attr_e( 'Order By:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'order_by' ); ?>" name="<?php echo $this->get_field_name( 'order_by' ); ?>" style="width:100%;">
        <option value="ID" <?php selected( $order_by, 'ID' ); ?>><?php esc_attr_e( 'ID', APLW_TEXT_DOMAIN ) ?></option>
        <option value="date" <?php selected( $order_by, 'date' ); ?>><?php esc_attr_e( 'Date', APLW_TEXT_DOMAIN ) ?></option>
        <option value="author" <?php selected( $order_by, 'author' ); ?>><?php esc_attr_e( 'Author', APLW_TEXT_DOMAIN ) ?></option>
        <option value="title" <?php selected( $order_by, 'title' ); ?>><?php esc_attr_e( 'Title', APLW_TEXT_DOMAIN ) ?></option>
        <option value="modified" <?php selected( $order_by, 'modified' ); ?>><?php esc_attr_e( 'Modified', APLW_TEXT_DOMAIN ) ?></option>
        <option value="meta_value" <?php selected( $order_by, 'meta_value' ); ?>><?php esc_attr_e( 'ACF meta_value (string)', APLW_TEXT_DOMAIN ) ?></option>
        <option value="meta_value_num" <?php selected( $order_by, 'meta_value_num' ); ?>><?php esc_attr_e( 'ACF meta_value_num (number)', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php esc_attr_e( 'Order:', APLW_TEXT_DOMAIN ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" style="width:100%;">
        <option value="ASC" <?php selected( $order, 'ASC' ); ?>><?php esc_attr_e( 'ASC', APLW_TEXT_DOMAIN ) ?></option>
        <option value="DESC" <?php selected( $order, 'DESC' ); ?>><?php esc_attr_e( 'DESC', APLW_TEXT_DOMAIN ) ?></option>
    </select>
</p>
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'acf' ) ); ?>"><?php esc_attr_e( 'ACF:', APLW_TEXT_DOMAIN ); ?></label> 
    <input class="widefat" 
        id="<?php echo esc_attr( $this->get_field_id( 'acf' ) ); ?>" 
        name="<?php echo esc_attr( $this->get_field_name( 'acf' ) ); ?>" 
        type="text" 
        value="<?php echo esc_attr( $acf ); ?>">
</p>