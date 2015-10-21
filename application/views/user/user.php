<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>          <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">User Control Panel</h3>
                    <p class="text-center"><?= $username;?> | <?= $email;?></p>
                    <p class="text-center"><a href="<?= $urls['change_pass'];?>">Change Password</a></p>
                    <p class="text-center"><a href="<?= $urls['avatar_page'];?>">Edit Avatar</a></p>
                </div>
            </div>
