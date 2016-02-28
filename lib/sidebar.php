<?php
/**
 * Determines whether or not to display the sidebar based on an array of conditional tags or page templates.
 *
 * If any of the is_* conditional tags or is_page_template(template_file) checks return true, the sidebar will NOT be displayed.
 *
 * @param array list of conditional tags (http://codex.wordpress.org/Conditional_Tags)
 * @param array list of page templates. These will be checked via is_page_template()
 *
 * @return boolean True will display the sidebar, False will not
 *
 */
class BigCloudCMS_Sidebar {
  private $conditionals;
  private $templates;

  public $display = true;

  function __construct($conditionals = array(), $templates = array()) {
    $this->conditionals = $conditionals;
    $this->templates    = $templates;

    $conditionals = array_map(array($this, 'check_conditional_tag'), $this->conditionals);
    $templates    = array_map(array($this, 'check_page_template'), $this->templates);

    if (in_array(true, $conditionals) || in_array(true, $templates)) {
      $this->display = false;
    }
  }

  private function check_conditional_tag($conditional_tag) {
    if (is_array($conditional_tag)) {
      return call_user_func_array($conditional_tag[0], $conditional_tag[1]);
    } else {
      return $conditional_tag();
    }
  }

  private function check_page_template($page_template) {
    return is_page_template($page_template);
  }
}

function bigcloudcms_sidebar_id() {
    if(is_front_page()) {
      global $bigcloudcms_premium;
        if (!empty($bigcloudcms_premium['home_sidebar'])) {
          $sidebar = $bigcloudcms_premium['home_sidebar'];
        } else {
          $sidebar = 'sidebar-primary';
        } 
    } elseif( class_exists('woocommerce') and (is_shop())) {
      global $bigcloudcms_premium;
        if (!empty($bigcloudcms_premium['shop_sidebar'])) {
          $sidebar = $bigcloudcms_premium['shop_sidebar'];
        } else {
          $sidebar = 'sidebar-primary';
        } 
    } elseif( class_exists('woocommerce') and (is_product_category() || is_product_tag())) {
        global $bigcloudcms_premium;
        if (!empty($bigcloudcms_premium['shop_cat_sidebar'])) {
          $sidebar = $bigcloudcms_premium['shop_cat_sidebar'];
        } else {
          $sidebar = 'sidebar-primary';
        } 
    } elseif (class_exists('woocommerce') and is_product()) {
      global $post;
        $sidebar_name = get_post_meta( $post->ID, '_kad_sidebar_choice', true ); 
        if (empty($sidebar_name) || $sidebar_name == 'default') {
          global $bigcloudcms_premium;
          if(!empty($bigcloudcms_premium['product_sidebar_default_sidebar'])) {
            $sidebar = $bigcloudcms_premium['product_sidebar_default_sidebar'];
          } else {
            $sidebar = 'sidebar-primary';
          }
        } else if(!empty($sidebar_name)) {
          $sidebar = $sidebar_name;
        } else {
          $sidebar = 'sidebar-primary';
        }
    } elseif( class_exists('woocommerce') and (is_account_page())) {
            $sidebar = '';
            get_template_part('templates/account', 'sidebar');
    } elseif( is_page_template('page-blog.php') || is_page_template('page-blog-grid.php') || is_page_template('page-sidebar.php') || is_page_template('page-feature-sidebar.php') || is_single() || is_singular('staff') ) {
      global $post;
        $sidebar_name = get_post_meta( $post->ID, '_kad_sidebar_choice', true ); 
        if (!empty($sidebar_name)) {
            $sidebar = $sidebar_name;
        } else {
          $sidebar = 'sidebar-primary';
        } 
    } elseif (is_archive()) {
      global $bigcloudcms_premium; 
        if(isset($bigcloudcms_premium['blog_cat_sidebar'])) {
          $sidebar = $bigcloudcms_premium['blog_cat_sidebar'];
        } else  {
          $sidebar = 'sidebar-primary';
        } 
    }
    elseif(is_category()) {
      global $bigcloudcms_premium; 
        if(isset($bigcloudcms_premium['blog_cat_sidebar'])) {
          $sidebar = $bigcloudcms_premium['blog_cat_sidebar'];
        } else  {
          $sidebar = 'sidebar-primary';
        } 
    }
    elseif (is_tag()) {
      $sidebar = 'sidebar-primary';
    }
    elseif (is_post_type_archive()) {
      $sidebar = 'sidebar-primary';
    }
     elseif (is_day()) {
       $sidebar = 'sidebar-primary';
     }
     elseif (is_month()) {
       $sidebar = 'sidebar-primary';
     }
     elseif (is_year()) {
       $sidebar = 'sidebar-primary';
     }
     elseif (is_author()) {
       $sidebar = 'sidebar-primary';
    }
    elseif (is_search()) {
      global $bigcloudcms_premium; 
        if(isset($bigcloudcms_premium['search_sidebar'])) {
          $sidebar = $bigcloudcms_premium['search_sidebar'];
        } else  {
          $sidebar = 'sidebar-primary';
        } 
    } else {
      $sidebar = 'sidebar-primary';
    }

    return apply_filters('bigcloudcms_sidebar_id', $sidebar);
}