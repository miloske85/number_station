<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-4">
                    <p><u>Search</u></p>

                </div>
                <div class="col-md-8">
                	<p><u>Search messages:</u></p>
	                   <?= form_open($forms['admin_search_message'], array('class' => 'form'));?> 
	                   	<p><input type="text" class="form-control" name="search_message" placeholder="Search messages"></p>
	                   	<p><button class="btn btn-info">Search</button></p>
	                   </form>

                   <p><u>Search users:</u></p>
	                   <?= form_open($forms['admin_search_username'], array('class' => 'form'));?> 
	                   	<p><input type="text" class="form-control" name="search_username" placeholder="Search by username"></p>
	                   	<p><button class="btn btn-info">Search</button></p>
	                   </form>

	                   <?= form_open($forms['admin_search_email'], array('class' => 'form'));?> 
	                   	<p><input type="text" class="form-control" name="search_email" placeholder="Search by email"></p>
	                   	<p><button class="btn btn-info">Search</button></p>
	                   </form>
                </div>
            </div>
