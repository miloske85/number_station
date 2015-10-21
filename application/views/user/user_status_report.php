<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center"><?= $status_report;?>
                    <?php
                    if(isset($message)):
                    if(!isset($delete_conf)):
                    ?>
                    <a href="<?= $urls['delete_private_message'].'/'.$message->id.'/c';?>"><button class="btn btn-danger">Delete</button></a>
                     <a href="<?= $urls['private_messages'];?>"><button class="btn btn-success">Cancel</button></a>
                    <?php
                    endif;
                    endif;
                    ?>
                    </h3>
                </div>
            </div>
