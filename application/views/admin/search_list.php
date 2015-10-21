<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8">
                	<p>
                		<?php
                			if(isset($search_count)):
                				?>
                			Found <?= $search_count;?> matches.
                			<?php
                			endif;
                		?>
                	</p>
                	<p>Results are ordered by date, from oldest to newest.</p>
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <th>
								IP
							</th>
							<th>
								Date
							</th>
							<th>
								Username
							</th>
							<th>
								Referer
							</th>
							<th>
								Uri
							</th>
							<th>
								User Agent
							</th>
                        </tr>
                        <?php
							if(is_array($hits_list)):
                            foreach($hits_list as $hit):
                                ?>
                                    <tr>
                                        <td><?= $hit['ip'];?></td><td><?= date('Y-m-d H:i:s',$hit['date']);?></td><td><?= $hit['username']; ?></td><td><?= $hit['referer'];?></td><td><?= $hit['uri'];?></td><td><?= $hit['ua'];?></td>
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
