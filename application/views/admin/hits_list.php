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
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <th>
								IP
								<a href="<?= $urls['iplog_show_visit_list'].'/ip/ASC';?>"><i class="fa fa-long-arrow-up"></i></a>
								<a href="<?= $urls['iplog_show_visit_list'].'/ip/DESC';?>"><i class="fa fa-long-arrow-down"></i></a>
							</th>
							<th>
								Date
								<a href="<?= $urls['iplog_show_visit_list'].'/date/ASC';?>"><i class="fa fa-long-arrow-up"></i></a>
								<a href="<?= $urls['iplog_show_visit_list'].'/date/DESC';?>"><i class="fa fa-long-arrow-down"></i></a>
							</th>
							<th>
								Username
								<a href="<?= $urls['iplog_show_visit_list'].'/username/ASC';?>"><i class="fa fa-long-arrow-up"></i></a>
								<a href="<?= $urls['iplog_show_visit_list'].'/username/DESC';?>"><i class="fa fa-long-arrow-down"></i></a>
							</th>
							<th>
								Referer
								<a href="<?= $urls['iplog_show_visit_list'].'/referer/ASC';?>"><i class="fa fa-long-arrow-up"></i></a>
								<a href="<?= $urls['iplog_show_visit_list'].'/referer/DESC';?>"><i class="fa fa-long-arrow-down"></i></a>
							</th>
							<th>
								Uri
								<a href="<?= $urls['iplog_show_visit_list'].'/uri/ASC';?>"><i class="fa fa-long-arrow-up"></i></a>
								<a href="<?= $urls['iplog_show_visit_list'].'/uri/DESC';?>"><i class="fa fa-long-arrow-down"></i></a>
							</th>
							<th>
								User Agent
								<a href="<?= $urls['iplog_show_visit_list'].'/ua/ASC';?>"><i class="fa fa-long-arrow-up"></i></a>
								<a href="<?= $urls['iplog_show_visit_list'].'/ua/DESC';?>"><i class="fa fa-long-arrow-down"></i></a>
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
