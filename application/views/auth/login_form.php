<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($on_hold_message))
{
	if (isset($login_error_mesg))
	{
		echo '
			<div class="panel panel-danger">
				<div class="panel-heading">
					Login Error #' . $this->authentication->login_errors_count . '/' . config_item('max_allowed_attempts') . '
				</div>
				<div class="panel-body">Invalid Username, Email Address, or Password.</div>
			</div>
		';
	}

	if ($this->input->get(AUTH_LOGOUT_PARAM))
	{
		echo '
			<div class="panel panel-success">
				<div class="panel-heading">Log out</div>
				<div class="panel-body">You have successfully logged out.</div>
			</div>
		';
	}

	echo '<h2>Login</h2>';

	echo form_open($login_url, ['class' => 'std-form']);
?>

	<div class="form-group">
		<label for="login_string">Username</label>
		<input type="text" name="login_string" id="login_string" class="form-control" autofocus maxlength="255" />
	</div>

	<div class="form-group">
		<label for="login_pass">Password</label>
		<input type="password" name="login_pass" id="login_pass" class="form-control" autocomplete="off" />
	</div>

		<?php
      // Remember me checkbox
			if (config_item('allow_remember_me'))
			{
				echo '
					<div class="form-group form-check">
						<input type="checkbox" id="remember_me" name="remember_me" class="form-check-input" value="yes" />
						<label for="remember_me" class="form-check-label">Remember Me</label>
					</div>
        ';
			}
		?>

		<input type="submit" name="submit" value="Login" id="submit_button" class="btn btn-primary" />

	</div>
</form>

<?php

	}
	else
	{
		// Excessive login attempts error message
		echo '
			<div class="card bg-danger text-white mb-3">
				<div class="card-header font-weight-bold p-2">
					Excessive Login Attempts
				</div>
				<div class="card-body p-2">
					<p class="card-text">
						You have exceeded the maximum number of failed login attempts that this website will allow.
					</p>
					<p class="card-text">
						Your access to login and account recovery has been blocked for ' . ((int) config_item('seconds_on_hold') / 60) . ' minutes.
					</p>
					<p class="card-text">
						Please use the <a href="/examples/recover">Account Recovery</a> after ' . ((int) config_item('seconds_on_hold') / 60) . ' minutes has passed,<br />
						or contact us if you require assistance gaining access to your account.
					</p>
				</div>
			</div>
		';
	}