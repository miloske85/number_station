<html>
<body>
	<h1>Password Reset Request - Number Relay Page</h1>
	<p>If you haven't submitted this request for a new password please ignore this email.</p>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?></p>
</body>
</html>