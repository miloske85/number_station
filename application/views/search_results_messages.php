<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-2">
                    <p><u>Search Results</u></p>
                    <p>Found: <?= $search_count;?> matches</p>
                    <span class="h2">&nbsp;</span>
                </div>
                <div class="col-md-10">
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <th>Username</th><th>Message</th><th>View</th>
                        </tr>                
	                	<?php
                            if(is_array($search_results)):
	                		foreach($search_results as $row):
	                		?>
	                		<tr>
	                			<td><?= $row['name'];?></td><td><?= $row['message'];?></td><td><a href="<?= $urls['user_show_message'].'/'.$row['id'];?>">View</a></td>
	                		</tr>
	                	<?php
	                	endforeach;
                        endif;
	                	?>
	                </table>
                    <p><?= $pag_links;?></p>
                </div>
            </div>
