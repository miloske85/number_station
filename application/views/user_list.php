<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>          <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h4>List of registered users</h4>
                    <ul class="list-unstyled">
                        <?php
                            foreach($user_list as $user):
                            ?>
                            <li><a href="<?= $urls['show_user'].'/'.$user['id'];?>"><?= $user['username'];?></a></li>
                            <?php
                            endforeach;
                        ?>
                    </ul>
                    <p><?= $pag_links;?></p>
                </div>
            </div>
