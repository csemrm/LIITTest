<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
    <head>
        <?php if (!empty($is_blog)) : ?>
            <title><?php echo $CI->fuel_blog->page_title($page_title, ' : ', 'right') ?></title>
        <?php else : ?>
            <title><?php echo fuel_var('page_title', '', false) ?></title>
        <?php endif ?>
        <meta charset="UTF-8" />
        <meta name="ROBOTS" content="ALL" />
        <meta name="MSSmartTagsPreventParsing" content="true" />

        <meta name="keywords" content="<?php echo fuel_var('meta_keywords') ?>" />
        <meta name="description" content="<?php echo fuel_var('meta_description') ?>" />
        <link rel="shortcut icon" href="">
            <?php
            $this->load->helper('google');
            echo google_analytics('UA-42093651-1');
            ?>
            <?php echo css('common,mptv/common_mptv,mptv/header,mptv/search,mptv/dropdown,orange'); ?>
            <?php echo css($css); ?>

            <script type="text/javascript" src="<?php echo site_url() ?>fuel/modules/fuel/assets/js/jquery/jquery.js"></script>
            <?php echo js('jquery.validate.min'); ?>
            <?php echo js('iCheck.js'); ?>
            <?php echo js($js); ?>

            <base href="<?php echo site_url() ?>" />
            <?php if (!empty($is_blog)) : ?>
                <?php echo $CI->fuel_blog->header() ?>
            <?php endif; ?>
    </head>
    <body class="<?php echo fuel_var('body_class', 'Body Class'); ?>">
        <!--  div id="orange_line"></div-->
        <div id="container">
            <div id="header" class="header_insections">	

            </div>
            <div id="page_content">