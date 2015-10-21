<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>		<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="pull-right">
                        
                    </p>                
                	<p>
                		<?php
                			foreach($admin_nav as $link):
                				?>
                				<a href="<?= $link['url'];?>"><?= $link['label'];?></a> |
                				<?php
                				endforeach;
                		?>
                        <a href="<?= $urls['home'];?>">Home</a>
                	</p>
                    <span class="h1 clearfix">&nbsp;</span>
                </div>
            </div>
