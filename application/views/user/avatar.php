<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>          <div class="row">
                <div class="col-md-12">
                    <h4 class="text-center">Your current avatar</h4>
                    <p class="text-center">
                        <?php
                            if(isset($avatar)):
                        ?>
                        <img src="<?= $avatar;?>" alt="avatar">
                        <?php
                            else:
                        ?>
                        <img src="<?= $assets['avatar_placeholder'];?>" alt="placeholder-avatar">
                        <?php
                            endif;
                        ?>
                    </p>
                    <div class="h1">&nbsp;</div>
                    <div class="text-center">
                    	<?= form_open_multipart($forms['avatar_upload'], array('class' => 'form form-inline'));?>
	                    	<input type="file" class="form-control" name="userfile">
	                    	<button class="btn btn-primary">Upload</button>
                    	</form>
                        <p>Allowed formats: GIF, JPG and PNG</p>
                        <p>Max. filesize 50KB</p>
                        <p>Max. dimensions 120x120 px</p>
                        <p class="h2">&nbsp;</p>
                        <p><a href="<?= $urls['user_delete_avatar'];?>">Delete avatar</a></p>
                    </div>
                </div>
            </div>
