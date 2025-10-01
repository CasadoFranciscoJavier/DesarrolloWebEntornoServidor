<?php
/**
 * Title: Banner Block
 * Slug: cv-workfolio/banner-block
 * Categories: banner
 * Block Types: core/template-part/banner
 */
?>

<!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/banner.png","id":45,"dimRatio":0,"customOverlayColor":"#4a4340","isUserOverlayColor":false,"minHeight":700,"minHeightUnit":"px","className":"banner-section","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-cover banner-section" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;min-height:700px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#4a4340"></span><img class="wp-block-cover__image-background wp-image-45" alt="" src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/banner.png" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"wow fadeInLeft","style":{"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"constrained","justifyContent":"center","contentSize":"90%"}} -->
<div class="wp-block-group wow fadeInLeft" style="padding-right:0;padding-left:0"><!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"slider-banner"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center slider-banner"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"className":"is-slide-heading","style":{"typography":{"fontSize":"38px","fontStyle":"normal","fontWeight":"600"}},"textColor":"background","fontFamily":"fira-sans"} -->
<h2 class="wp-block-heading is-slide-heading has-background-color has-text-color has-fira-sans-font-family" style="font-size:38px;font-style:normal;font-weight:600"><?php esc_html_e('Hi, I Am Kelvin Loee ','cv-workfolio'); ?><br><?php esc_html_e('A Best Designer','cv-workfolio'); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"left","style":{"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"300"}},"textColor":"background","fontFamily":"fira-sans"} -->
<p class="has-text-align-left has-background-color has-text-color has-fira-sans-font-family" style="font-size:15px;font-style:normal;font-weight:300"><?php esc_html_e('Lorem Ipsum is simply dummy text of the printing','cv-workfolio'); ?> <br><?php esc_html_e('and typesetting industry.','cv-workfolio'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"banner-btn"} -->
<div class="wp-block-buttons banner-btn"><!-- wp:button {"backgroundColor":"accent","textColor":"base","className":"theme-btn","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"},"spacing":{"padding":{"left":"25px","right":"25px","top":"10px","bottom":"10px"}},"border":{"radius":"10px"}},"fontFamily":"fira-sans"} -->
<div class="wp-block-button has-custom-font-size theme-btn has-fira-sans-font-family" style="font-size:16px;font-style:normal;font-weight:400"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="#" style="border-radius:10px;padding-top:10px;padding-right:25px;padding-bottom:10px;padding-left:25px"><?php esc_html_e('Download CV','cv-workfolio'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"40%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:40%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->