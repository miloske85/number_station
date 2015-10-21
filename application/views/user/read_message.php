<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8">
                    <h3 class="text-center">Private message</h3>
                        <p><strong>From:</strong> <a href="<?= $urls['show_user'].'/'.$pm->sender;?>"><?= $pm->username;?></a></p>
                        <p><strong>Date:</strong> <?= date($data['date_format'], $pm->date_sent);?></p>
                        <p><strong>Subject:</strong> <?= $pm->subject;?></p>
                        <p class="h3">&nbsp;</p>
                        <p><?= $pm->message;?></p>
                        <p class="h3">&nbsp;</p>
                        <p><a href="<?= $urls['delete_private_message'].'/'.$pm->id;?>"><button class="btn btn-danger">Delete</button></a></p>
                        <p><a href="<?= $urls['send_private_message'].'/'.$pm->username.'/'.$pm->id;?>"><button class="btn btn-info">Reply</button></a></p>
                </div>
                <div class="col-md-4">
                    <span class="h1">&nbsp;</span>
                    <p><a href="<?= $urls['private_messages'];?>">Back to private messages</a></p>
                    <p><a href="<?= $urls['home'];?>">Home</a></p>
                </div>
            </div>
