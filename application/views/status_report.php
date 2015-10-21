<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center"><?= $status_report;?></h3>
                    <?php
                        if(isset($status_report_expl)):
                    ?>
                    <p class="text-center"><?= $status_report_expl;?></p>
                    <?php
                        endif;
                    ?>
                    <?php
                    	if(isset($urls['redirect_target'])):
                    		?>
                    		<p id="redirectTarget" class="dataHidden">
                    			<?=  $urls['redirect_target'];?>
                    		</p>
                    		<p class="text-center">Redirecting to: <a href="<?= $urls['redirect_target'];?>"><?= $urls['redirect_target'];?></a>...</p>
                    		<script src="<?= $assets['js_redirect'];?>"></script>
                    		<?php
                    	endif;
                    ?>                    
                </div>
            </div>
