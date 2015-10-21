<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8">
                    <h3 class="text-center">Listing of a message</h3>
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <th>Property</th><th>Value</th>
                        </tr>
                        <tr>
                            <td>ID</td><td><?= $message->id;?></td>
                        </tr>
                        <tr>
                            <td>Username</td><td><?= $message->username;?></td>
                        </tr>                            
                        <tr>
                            <td>User ID</td><td><a href="<?= $urls['admin_show_user'].'/'.$message->user_id;?>"><?= $message->user_id;?></a></td>
                        </tr>
                        <tr>
                            <td>Date</td><td><?= date('Y-m-d H:i:s', $message->date_mess);?></td>
                        </tr>
                        <tr>
                            <td>Active</td><td><?= $message->active;?></td>
                        </tr>
                        <tr>
                            <td>Message</td><td><?= $message->message;?></td>
                        </tr>                            
                    </table> 
                </div>
                <div class="col-md-4">
                    <span class="h1">&nbsp;</span>
                    <p><a href="<?= $urls['admin_edit_message'].'/'.$message->id;?>"><button class="btn btn-warning">Edit</button></a></p>
                    <p><a href="<?= $urls['admin_delete_message'].'/'.$message->id;?>"><button class="btn btn-danger">Delete</button></a></p>
                </div>
            </div>
