<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?><!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Test</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--<link rel="apple-touch-icon" href="apple-touch-icon.png">-->
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="<?= $css_url;?>">
        <script src="<?= $modernizr_url;?>"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">NUMBERS RELAY PAGE</h1>
                    <span class="h1">&nbsp;</span>
                </div>
            </div>
<!-- Header end -->            
            <div class="row">
                <div class="col-md-4">
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>

                </div>
                <div class="col-md-8">
                    <?= form_open('test/post', array('class' => 'form form-inline'));?>
                        <div class="row">
                            <div class="col-md-12">
                                <?= form_error('name');?>
                                <input class="form-control" name="name" type="text" value="<?= set_value('name');?>" placeholder="Name">
                                <?= form_error('captcha');?>
                                <input class="form-control" name="captcha" type="text" value="<?= set_value('captcha');?>" placeholder="Captcha">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p><?= $captcha['image'];?></p>
                                <?= form_error('message');?>
                                <textarea class="form-control" name="message" type="text" cols="53" rows="10" ><?= set_value('message');?></textarea>
                            </div>
                        </div>
                        
                        <button class="btn btn-default">Send</button>
                    </form>
                </div>
            </div>
        </div>
<!-- footer start -->

    </body>
</html> 