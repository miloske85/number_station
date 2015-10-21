<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?><!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?= $pageTitle;?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--<link rel="apple-touch-icon" href="apple-touch-icon.png">-->
        <link rel="icon" href="<?= $assets['favicon'];?>">

        <link rel="stylesheet" href="<?= $assets['css'];?>">
        <link rel="stylesheet" href="<?= $assets['css_patch']; ?>">
        <link rel="stylesheet" href="<?= $assets['fa_css'];?>">
        <script src="<?= $assets['jquery'];?>"></script>
        <script src="<?= $assets['modernizr'];?>"></script>        
        <script src="<?= $assets['validation_js_lib'];?>"></script>
        
        
    </head>
    <body><!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

