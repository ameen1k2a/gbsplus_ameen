<?php require(APPPATH . 'views/login_partials/header_login.php'); ?>

<div class="col-lg-6 col-md-6 form-container">
		<div class="col-lg-8 col-md-12 col-sm-9 col-xs-12 form-box text-center">

			<?php if ($this->session->flashdata('success')): ?>
			    <div class="alert alert-success">
			        <?php echo $this->session->flashdata('success'); ?>
			    </div>
			<?php endif; ?>
			<?php if ($this->session->flashdata('error')): ?>
			    <div class="alert alert-danger">
			        <?php echo $this->session->flashdata('error'); ?>
			    </div>
			<?php endif; ?>

			<div class="logo mb-3">
				<img src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width="100px">
			</div>
			<div class="heading mb-3">
				<h4>Login into your account</h4>
			</div>
			<?php echo form_open('', array('id' => 'loginForm')) ?>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-envelope"></i></span>
						</div>
						<input class="form-control" name="email" type="text" value="<?php echo set_value('email'); ?>" placeholder="Email" required>
					</div>
					<div class="text-white" id="email_error"><?php echo form_error('email'); ?></div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-lock"></i></span>
						</div>
						<input class="form-control" name="password" type="password" placeholder="Password" required>
					</div>
					<div class="text-white" id="password_error"><?php echo form_error('password'); ?></div>
				</div>

				<div class="text-right mb-3">
					<button type="submit" name="login" value="login" id="login" class="btn">Login</button>
				</div>
			<?php echo form_close() ?>

			
		</div>
	</div>

<div class="col-lg-6 col-md-6 d-none d-md-block image-container"></div>


<?php require(APPPATH . 'views/login_partials/footer_login.php'); ?>
