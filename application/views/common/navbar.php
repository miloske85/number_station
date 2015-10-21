<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div role="navigation" class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?= $urls['home'];?>">NUMBERS RELAY PAGE</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<?php
      		if($nav_uri == 'messages'):
      	?>
        <li class="active"><a href="<?= $urls['home'];?>">Home <span class="sr-only">(current)</span></a></li>
        <?php
        	else:
        ?>
    	<li><a href="<?= $urls['home'];?>">Home <span class="sr-only">(current)</span></a></li>
    	<?php
    		endif;
    	?>

    	<?php
    		if($nav_uri == 'users'):
    	?>
    	<li class="active"><a href="<?= $urls['list_users'];?>">List Users</a></li>
    	<?php
    		else:
    	?>
        <li><a href="<?= $urls['list_users'];?>">List Users</a></li>
        <?php
        	endif;
        ?>

        <?php
        	if($nav_uri == 'about'):
        ?>
    	<li class="active"><a href="<?= $urls['about'];?>">About</a></li>
    	<?php
    		else:
    	?>
        <li><a href="<?= $urls['about'];?>">About</a></li>
        <?php
        	endif;
        ?>

        <?php
        	if($nav_uri == 'ext-links'):
        ?>
    	<li class="active"><a href="<?= $urls['external_links'];?>">External Links</a></li>
    	<?php
    		else:
    	?>
        <li><a href="<?= $urls['external_links'];?>">External Links</a></li>
        <?php
        	endif;
        ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
		<?php
			if($data['logged_in']):
        ?>
        <li><p class="navbar-text">Hello, <?= $greet_user;?>!</p></li>
        <?php
				if(isset($urls['admin'])):
				?>

					<?php
						if($nav_uri == 'admin'):
					?>
					<li class="active"><a href="<?= $urls['admin'];?>">Admin CP</a></li>
					<?php
						else:
					?>
					<li><a href="<?= $urls['admin'];?>">Admin CP</a></li>
					<?php
						endif;
					?>
				<?php
				endif;
				?>

				<?php
					if($nav_uri == 'user'):
				?>
				<li class="active"><a href="<?= $urls['user_cp'];?>" title="User CP"><i class="fa fa-user"></i></a></li>
				<?php
					else:
				?>
				<li><a href="<?= $urls['user_cp'];?>" title="User CP"><i class="fa fa-user"></i></a></li>
				<?php
					endif;
				?>

				<?php
					if($nav_uri == 'pm'):
				?>
				<li class="active"><a href="<?= $urls['private_messages'];?>" title="Private Messages">
				<?php
					else:
				?>
				<li><a href="<?= $urls['private_messages'];?>" title="Private Messages">
				<?php
					endif;
				?>

				<?php
				if($unread_pm_count != 0):
				?>
					<?= $unread_pm_count;?>&nbsp;
				<?php
					endif;
				?>
				<i class="fa fa-envelope-o"></i></a></li>
				<li><a href="<?= $urls['logout'];?>"><i class="fa fa-sign-out"></i> Log Out</a></li>
		
		<?php
			else:
		?>
			<?php
				if($nav_uri == 'login'):
			?>
			<li class="active"><a href="<?= $urls['login'];?>">Login</a></li>
			<?php
				else:
			?>
			<li><a href="<?= $urls['login'];?>">Login</a></li>
			<?php
				endif;
			?>

			<?php
				if($nav_uri == 'register'):
			?>
			<li class="active"><a href="<?= $urls['register'];?>">Register</a></li>
			<?php
				else:
			?>
			<li><a href="<?= $urls['register'];?>">Register</a></li>
			<?php
				endif;
			?>
		<?php
			endif;
		?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<noscript><p style="color: red" class="text-center">Javascript is disabled or not supported by your browser. Most of the things on this site will work, but your experience would be better with Javascript.</p></noscript>
		</div>
	</div>
</div>

