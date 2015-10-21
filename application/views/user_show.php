<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>          <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h4>Public profile:</h4>
                        <p><?= $user['username'];?></p>
                        <?php
                            if($user['avatar']):
                        ?>
                        <p><img src="<?= $avatar;?>" alt="avatar"></p>
                        <?php
                        else:
                        ?>
                        <p><img src="../../img/avatar_placeholder.png" alt="avatar_placeholder"></p>
                        <?php
                        endif;
                        ?>
                        <?php
                            if(!$data['logged_in']):
                        ?>
                        <p><a href="<?= $urls['login'];?>">Log In to send private message</a></p>
                        <?php
                            else:
                        ?>
                        <p><a href="<?= $urls['send_private_message'].'/'.$user['username'];?>">Send private message</a></p>
                        <?php
                            endif;
                        ?>
                </div>
            </div>
