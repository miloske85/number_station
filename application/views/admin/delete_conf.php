<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Are you sure you want to delete this <?= $item_type;?>?</h3>
                    <p class="text-center"><a href="<?= $urls['admin_delete_link'].'/'.$item_type.'/'.$id.'/c';?>"><button class="btn btn-danger">Delete</button></a>
                    &nbsp;&nbsp;<a href="<?= $urls['admin_cancel_link'];?>"><button class="btn btn-success">Cancel</button></a></p>
                </div>
            </div>
