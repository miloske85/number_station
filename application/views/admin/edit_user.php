<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8">
                    <h3 class="text-center">Listing of a user</h3>
                    <?php
                        $formOpen = 'admin/ap/edituser/'.$user->id;
                    ?>
                        <?= form_open($formOpen, array('class' => 'form'));?>
                            <p>
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" value="<?= $user->username;?>">
                            </p>
                            <p>
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" value="<?= $user->email;?>">
                            </p>
                            <p>
                                <label for="active">Active (1|0)</label>
                                <input type="text" class="form-control" name="active" value="<?= $user->active;?>">
                            </p>
                            <p><button class="btn btn-default">Submit</button></p>
                        </form>
                        <p><a href="<?= $urls['admin_show_user'].'/'.$user->id;?>"><button class="btn btn-default">Cancel</button></a></p>
                </div>
                <div class="col-md-4">
                    <span class="h1">&nbsp;</span>
                    <p><strong>Warning: There is no data validation for submitting his form. Submitting empty entry will erase data. All changes are irrecoverable!</strong></p>
                </div>
            </div>
