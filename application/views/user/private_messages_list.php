<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                   <p><a href="<?= $urls['send_private_message'];?>">Send Private Message</a></p> 

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 clearfix">
                    <div class="h1">&nbsp;</div>
                </div>
                <div class="col-md-8 col-md-offset-2">
					<table class="table table-condensed">
						<tr>
							<th></th><th>Subject</th><th>Sender</th><th>Date</th>
						</tr>
                    <?php
                    foreach($private_messages as $pm):
                        ?>
                        <tr>
							<td>
							<?php
								if($pm['is_read'] == 0):
									echo '*';
								endif;
							?>
							</td><td><a href="<?= $urls['read_private_msg'].'/'.$pm['id'];?>"><?= $pm['subject'];?></a></td><td><a href="<?= $urls['show_user'].'/'.$pm['sender'];?>"><?= $pm['username'];?></a></td><td><?= date($data['date_format'],$pm['date_sent']);?></td>
						</tr>
                    <?php
                        endforeach;
                    ?>
                    </table>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <?= $pag_links; ?>
                </div>
            </div>
