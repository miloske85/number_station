<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8">
                    <h3 class="text-center">Listing of a user</h3>
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <th>Property</th><th>Value</th>
                        </tr>
                        <tr>
                            <td>Username</td><td><?= $user->username;?></td>
                        </tr>
                        <tr>
                            <td>Email</td><td><?= $user->email;?></td>
                        </tr>
                        <tr>
                            <td>Created On</td><td><?= date('Y-m-d H:i:s', $user->created_on);?></td>
                        </tr>
                        <tr>
                            <td>Last Login</td><td><?= date('Y-m-d H:i:s', $user->last_login);?></td>
                        </tr>
                        <tr>
                            <td>ID</td><td><?= $user->id;?></td>
                        </tr>
                        <tr>
                            <td>IP</td><td><?= $user->ip_address;?></td>
                        </tr>                            
                        <tr>
                            <td>Active</td><td><?= $user->active;?></td>
                        </tr>
                        <tr>
                            <td>Is Admin</td><td><?= $user->is_admin;?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <span class="h1">&nbsp;</span>
                    <p><a href="<?= $urls['admin_edit_user'].'/'.$user->id;?>"><button class="btn btn-warning">Edit</button></a></p>
                    <p><a href="<?= $urls['admin_delete_user'].'/'.$user->id;?>"><button class="btn btn-danger">Delete</button></a></p>
                    <?php
                        if($user->is_admin == 1){
                            ?>
                            <a href="<?= $urls['admin_promote_user'].'/'.$user->id.'/0';?>"><button class="btn btn-warning">Demote</button></a>
                            <?php
                        }
                        else{
                            ?>
                            <a href="<?= $urls['admin_promote_user'].'/'.$user->id.'/1';?>"><button class="btn btn-info">Promote</button></a>
                            <?php
                            } 
                    ?>
                </div>
            </div>
