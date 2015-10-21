<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-4">
					<p>Total number of hits: <?= $total_hits;?></p>
					<p>Hits by time:
						<ul>
							<li>Past 24h: <?= $hits_by_time['day'];?></li>
							<li>Past Week: <?= $hits_by_time['week'];?></li>
							<li>Past Month: <?= $hits_by_time['month'];?></li>
						</ul>
					</p>
                </div>
                <div class="col-md-8">
					<p><a href="<?= $urls['iplog_show_visit_list'];?>">View all visits</a></p>
					<p>
						<?= form_open($urls['iplog_search'], array('class' => 'form'));?>
							<p>
								<label for="iplogSearch">Search IP log</label>
								<input class="form-control" id="iplogSearch" name="iplogSearch">
							</p>
							<p>
								<label>
									Search criteria:
								</label>
								<label>
									<input type="radio" id="iplogSearchByIp" name="iplogSearchRadio" value="ip" checked>
									IP
								</label>
								<label>
									<input type="radio" id="iplogSearchByUser" name="iplogSearchRadio" value="username">
									Username
								</label>
								<label>
									<input type="radio" id="iplogSearchByRef" name="iplogSearchRadio" value="referer">
									Referer
								</label>
								<label>
									<input type="radio" id="iplogSearchByUri" name="iplogSearchRadio" value="uri">
									Uri
								</label>
							</p>
							<button class="btn btn-primary">Search</button>
						</form>
					</p>
                </div>
            </div>
