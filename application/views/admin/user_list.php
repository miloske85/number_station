<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8">
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <th>Username</th><th>Email</th><th>Active</th>
                        </tr>
                        <?php
							if(is_array($user_list)):
                            foreach($user_list as $user):
                                ?>
                                    <tr>
                                        <td><a href="<?= $urls['admin_show_user'].'/'.$user['id'];?>"><?= $user['username'];?></a></td><td><?= $user['email'];?></td><td><?= $user['active'];?></td>
                                    </tr>
                                <?php
                            endforeach;
                        ?>
                    </table>

                    <p><?= $pag_links;?></p>
                    <?php
						endif;
					?>
                </div>
            </div>
