<?php
// shortcode_icon_search
add_shortcode('shortcode_icon_search', 'shortcode_icon_search');
// [shortcode_icon_search show_wishlist=1 show_icon=1]
function shortcode_icon_search($atts)
{
    $atts = shortcode_atts(array(
        'show_wishlist' => 1,
        'show_icon' => 1,
    ), $atts);
    $show_wishlist = $atts['show_wishlist'];
    $show_icon = $atts['show_icon'];

    ob_start();
?>
    <div class="form-group">
        <input name="key_search" type="search" class="form-control search" placeholder="Search" required>
        <button class="btn btn-primary submit-search text-center" type="submit"><i class="icon-search"></i></button>
    </div>
<?php
    return ob_get_clean();
}
