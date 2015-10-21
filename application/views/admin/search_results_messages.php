<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-2">
                    <p><u>Search Results</u></p>
                    <p>Found: <?= $search_count;?> matches</p>
                </div>
                <div class="col-md-10">
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <th>Username</th><th>Message</th><th>Active</th><th>View</th><th>Edit</th>
                        </tr>                
	                	<?php
                            if(is_array($search_results)):
	                		foreach($search_results as $row):
	                		?>
	                		<tr>
	                			<td><a href="<?= $urls['admin_show_user'].'/'.$row['user_id'];?>"><?= $row['name'];?></a></td><td><?= $row['message'];?></td><td><?= $row['active'];?></td><td><a href="<?= $urls['admin_show_message'].'/'.$row['id'];?>">View</a></td><td><a href="<?= $urls['admin_edit_message'].'/'.$row['id'];?>">Edit</a></td>
	                		</tr>
	                	<?php
	                	endforeach;
                        endif;
	                	?>
	                </table>
                    <p><?= $pag_links;?></p>
                </div>
            </div>
