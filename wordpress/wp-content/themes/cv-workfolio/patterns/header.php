<?php
/**
 * Title: Header
 * Slug: cv-workfolio/header
 * Categories: header
 * Block Types: core/template-part/header
 */
?>

<!-- wp:group {"className":"homepage-header","style":{"color":{"background":"#434343"},"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-group homepage-header has-background" style="background-color:#434343;padding-right:0;padding-left:0"><!-- wp:columns {"className":"homepage-header-column","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
<div class="wp-block-columns homepage-header-column" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:column {"width":"25%","style":{"spacing":{"padding":{"top":"28px","bottom":"28px","left":"0","right":"0"}}},"backgroundColor":"base"} -->
<div class="wp-block-column has-base-background-color has-background" style="padding-top:28px;padding-right:0;padding-bottom:28px;padding-left:0;flex-basis:25%"><!-- wp:site-title {"textAlign":"center","style":{"typography":{"fontSize":"30px","fontStyle":"normal","fontWeight":"600"},"color":{"text":"#0c1830"},"elements":{"link":{"color":{"text":"#0c1830"}}}},"fontFamily":"fira-sans"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"75%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:75%"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"padding":{"top":"13px","bottom":"13px"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center" style="padding-top:13px;padding-bottom:13px"><!-- wp:column {"verticalAlignment":"center","className":"contact-box","style":{"spacing":{"padding":{"left":"20px"}}}} -->
<div class="wp-block-column is-vertically-aligned-center contact-box" style="padding-left:20px"><!-- wp:columns {"className":"contact-gap","style":{"border":{"radius":"0px"}}} -->
<div class="wp-block-columns contact-gap" style="border-radius:0px"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"mail-box","style":{"border":{"right":{"color":"var:preset|color|base","width":"0px"},"top":[],"bottom":[],"left":[]}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group mail-box" style="border-right-color:var(--wp--preset--color--base);border-right-width:0px">

<!-- wp:paragraph {"style":{"typography":{"fontSize":"15px","fontStyle":"normal","fontWeight":"400"}},"textColor":"base","fontFamily":"fira-sans"} -->
<p class="has-base-color has-text-color has-fira-sans-font-family" style="font-size:14px;font-style:normal;font-weight:400"><span class="dashicons dashicons-email"></span><?php esc_html_e('support@example.com','cv-workfolio'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":""} -->
<div class="wp-block-column"><!-- wp:group {"className":"mail-box","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group mail-box">

<!-- wp:paragraph {"style":{"typography":{"fontSize":"15px","fontStyle":"normal","fontWeight":"400"}},"textColor":"base","fontFamily":"fira-sans"} -->
<p class="has-base-color has-text-color has-fira-sans-font-family" style="font-size:14px;font-style:normal;font-weight:400"><span class="dashicons dashicons-phone"></span><?php esc_html_e ('+123-456-7890','cv-workfolio'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"20%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:20%"><!-- wp:group {"className":"wp-header-search-social","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group wp-header-search-social"><!-- wp:social-links {"size":"has-small-icon-size","className":"is-style-logos-only"} -->
<ul class="wp-block-social-links has-small-icon-size is-style-logos-only"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#","service":"youtube"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"menu-box","style":{"spacing":{"padding":{"left":"0px","top":"12px","bottom":"12px","right":"0px"}}},"backgroundColor":"base"} -->
<div class="wp-block-column is-vertically-aligned-center menu-box has-base-background-color has-background" style="padding-top:12px;padding-right:0px;padding-bottom:12px;padding-left:0px;flex-basis:50%"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"95%","style":{"spacing":{"padding":{"left":"20px"}}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="padding-left:20px;flex-basis:95%"><!-- wp:navigation {"textColor":"contrast","metadata":{"ignoredHookedBlocks":["woocommerce/customer-account"]},"className":"is-head-menu","style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"500"},"spacing":{"blockGap":"var:preset|spacing|40"}},"fontFamily":"fira-sans","layout":{"type":"flex","justifyContent":"left"}} -->
<!-- wp:navigation-link {"label":"Home","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"About","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Service","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Pages","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Blogs","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Contact Us","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"5%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:5%"><!-- wp:woocommerce/mini-cart {"cartAndCheckoutRenderStyle":"removed","productCountVisibility":"never"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->