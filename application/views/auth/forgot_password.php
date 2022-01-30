<form action="<?= site_url('auth/forgot_password') ?>" method="POST">

	<div class="container container-login animated fadeIn">
	
		<h3 class="text-center"><?php echo lang('forgot_password_heading');?>?</h3>
		<?php if($message !== null): ?>
            <div class="alert alert-danger text-light bg-danger" role="alert">
                  <?= $message ?>
            </div>
		<?php endif ?>
            <label class="mb-2">No problem! Enter your email below and we will send instructions to reset your password.</label>
		<div class="login-form">
			<div class="form-group form-floating-label">
				<input id="username" name="identity" type="text" class="form-control input-border-bottom" required>
				<label for="username" class="placeholder">Username</label>
			</div>
			<div class="form-action mb-3">
				<button type="submit" class="btn btn-primary btn-rounded btn-sm btn-login">Send Instructions</button>
			</div>
			<div class="login-account">
				<span class="msg">Powered by: </span>
				<a href="https://ronilcajan.ml" class="link">R Labs</a>
			</div>
		</div>
	</div>
</form>
