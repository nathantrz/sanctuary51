<!DOCTYPE html>
<html>
  <head itemscope itemtype="http://schema.org/WebSite">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
    <link rel="canonical" href="<?php echo home_url(); ?>" itemprop="url" />
    <title itemprop='name'><?php echo get_bloginfo('name'); ?></title>
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(get_post_type($post)); ?>>
    <div class="curtain" data-structure="curtain"></div>
    <?php // get_template_part('shared/svg-sprite'); ?>
    <header>
      <?php

      ?>
    </header>
