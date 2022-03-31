<?php
/*
 * laurels Breadcrumbs
*/
function laurels_custom_breadcrumbs() {

   $laurels_showonhome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $laurels_showcurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    global $post;
    if (is_home() || is_front_page()) {

        if ($laurels_showonhome == 1)
            echo '<div id="crumbs" class="font-14 color-fff conter-text laurels-breadcrumb"><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'laurels') . '</a></div>';
    } else {

        echo '<div id="crumbs" class="font-14 color-fff conter-text laurels-breadcrumb"><a href="' . esc_url(home_url('/')). '">' . esc_html__('Home', 'laurels') . '</a> ';
        if (is_category()) {
            $laurels_thisCat = get_category(get_query_var('cat'), false);
            if ($laurels_thisCat->parent != 0)
                echo esc_html(get_category_parents($laurels_thisCat->parent, TRUE, ' '));
            echo  '/ '.esc_html__('Archive by category', 'laurels') . ' " ' . single_cat_title('', false) . ' "';
        } elseif (is_search()) {
            echo  '/ '.esc_html__('Search Results For ', 'laurels') . ' " ' . get_search_query() . ' "';
        } elseif (is_day()) {
            echo '/ '.'<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ';
            echo '/ '.'<a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . esc_html(get_the_time('F') ). '</a> ';
            echo  '/ '.esc_html(get_the_time('d'));
        } elseif (is_month()) {
            echo '/ '.'<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ';
            echo  '/ '.esc_html(get_the_time('F'));
        } elseif (is_year()) {
            echo '/ '.esc_html(get_the_time('Y'));
        } elseif (is_single() && !is_attachment()) {            
            if (get_post_type() != 'post') {
                $laurels_post_type = get_post_type_object(get_post_type());
                $laurels_slug = $laurels_post_type->rewrite;
                echo '<a href="' . esc_url(home_url('/'. $laurels_slug['slug'] . '/')) .'">' . esc_html($laurels_post_type->labels->singular_name) . '</a>';
                if ($laurels_showcurrent == 1)
                    echo  esc_html(get_the_title()) ;
            } else {
                $laurels_cat = get_the_category();
                $laurels_cat = $laurels_cat[0];
                $laurels_cats = get_category_parents($laurels_cat, TRUE, ' ');
                if ($laurels_showcurrent == 0)
                    $laurels_cats =
                            preg_replace("#^(.+)\s\s$#", "$1", $laurels_cats);
                echo '/ '.$laurels_cats;
                if ($laurels_showcurrent == 1)
                    echo  '/ '.esc_html(get_the_title());
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $laurels_post_type = get_post_type_object(get_post_type());
            echo esc_html($laurels_post_type->labels->singular_name );
        } elseif (is_attachment()) {
            $laurels_parent = get_post($post->post_parent);
            $laurels_cat = get_the_category($laurels_parent->ID);
            $laurels_cat = $laurels_cat[0];
            echo esc_html(get_category_parents($laurels_cat, TRUE, '  '));
            echo '<a href="' . esc_url(get_permalink($laurels_parent)) . '">' . esc_html($laurels_parent->post_title) . '</a>';
            if ($laurels_showcurrent == 1)
                echo   esc_html(get_the_title());
        } elseif (is_page() && !$post->post_parent) {
            if ($laurels_showcurrent == 1)
                echo '/ '.esc_html(get_the_title());
        } elseif (is_page() && $post->post_parent) {
            $laurels_parent_id = $post->post_parent;
            $laurels_breadcrumbs = array();
            while ($laurels_parent_id) {
                $laurels_page = get_page($laurels_parent_id);
                $laurels_breadcrumbs[] = '<a href="' . get_permalink($laurels_page->ID) . '">' . get_the_title($laurels_page->ID) . '</a>';
                $laurels_parent_id = $laurels_page->post_parent;
            }
            $laurels_breadcrumbs = array_reverse($laurels_breadcrumbs);
            for ($laurels_i = 0; $laurels_i < count($laurels_breadcrumbs); $laurels_i++) {
                echo '/ '.$laurels_breadcrumbs[$laurels_i];
                if ($laurels_i != count($laurels_breadcrumbs) - 1)
                    echo ' ';
            }
            if ($laurels_showcurrent == 1)
                echo ' / '.get_the_title();
        } elseif (is_tag()) {
            echo  ' / '.esc_html__('Posts tagged', 'laurels') . ' " ' . esc_html(single_tag_title('', false)) . ' "';
        } elseif (is_author()) {
            global $author;
            $laurels_userdata = get_userdata($author);
            echo  ' / '.esc_html__('Articles Published by', 'laurels') . ' " ' . esc_html($laurels_userdata->display_name ). ' "';
        } elseif (is_404()) {
            echo ' / '.esc_html__('Error 404', 'laurels') ;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ' (';
            echo esc_html__('Page', 'laurels') . ' ' . esc_html(get_query_var('paged'));
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ')';
        }
        echo '</div>';
    }
} // end laurels_custom_breadcrumbs()