<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-4">
                    <p><u>Search Results</u></p>
                    <p>Found: <?= $search_count;?> matches</p>

                </div>
                <div class="col-md-8">
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <th>Username</th><th>Email</th><th>Active</th>
                        </tr>                
	                	<?php
	                		foreach($search_results as $row):
	                		?>
	                		<tr>
	                			<td><a href="<?= $urls['admin_show_user'].'/'.$row['id'];?>"><?= $row['username'];?></a></td><td><?= $row['email'];?></td><td><?= $row['active'];?></td>
	                		</tr>
	                	<?php
	                	endforeach;
	                	?>
	                </table>
                </div>
            </div>
