<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8">
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <th>User ID</th><th>Message</th><th>Active</th><th></th><th></th>
                        </tr>
                        <?php
							if(is_array($message_list)):
                            foreach($message_list as $messages):
                                ?>
                                    <tr>
                                        <td><a href="<?= $urls['admin_show_user'].'/'.$messages['user_id'];?>">
                                        <?= $messages['name'];?>
                                        <?php
                                        if($messages['user_id'] == 0):
											echo $messages['name'];
										else:
											echo $messages['username'];
										endif;	
                                        ?>
                                        </a></td><td><?= nl2br($messages['message']);?></td><td><?= $messages['active'];?></td><td><a href="<?= $urls['admin_show_message'].'/'.$messages['id'];?>">View</a></td><td><a href="<?= $urls['admin_edit_message'].'/'.$messages['id'];?>">Edit</a></td>
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
