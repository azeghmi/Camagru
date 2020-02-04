<?php

if (isset($_SESSION['change_password']) || isset($_SESSION['change_password_success']))
{
    if (isset($_SESSION['change_password_success']) && $_SESSION['change_password_success'] == "password_updated")
    {
        echo'<div id="login-section" class="section animate">
					<div id="notification" class="notification is-danger has-text-centered">
						<p>A <strong>new</strong> password has been updated.</p>
					</div>
				</div>';
        unset($_SESSION['change_password_success']);

    }
    else if ((isset($_SESSION['change_password_success']) && $_SESSION['change_password_success'] == "error_key")
        || (isset($_SESSION['change_password']) && $_SESSION['change_password'] == "error_key"))
    {
        echo'<div id="login-section" class="section animate">
					<div id="notification" class="notification is-danger has-text-centered">
						<p>An <strong>error</strong> occured with password validation key.</p>
						<p>Please <strong>renew</strong> your password reset link.</p>
					</div>
				</div>';
        unset($_SESSION['change_password']);
    }
}


// Notifications only for CONNECTED User
if (isset($_SESSION['username']))
{
    if (isset($_SESSION['change_username'])) {
        if ($_SESSION['change_username'] == "updated") {
            echo '<div id="login-section" class="section animate">
			        <div id="notification" class="notification is-info has-text-centered">
                        <p>A <strong>new username</strong> has been updated</p>
	                </div>
		        </div>';
            unset($_SESSION['change_username']);
        }
    }
    if (isset($_SESSION['change_mail'])) {
        if ($_SESSION['change_mail'] == "updated") {
            echo '<div id="login-section" class="section animate">
			        <div id="notification" class="notification is-info has-text-centered">
                        <p>A <strong>new mail</strong> has been updated</p>
                    </div>
                 </div>';
            unset($_SESSION['change_mail']);
        }
    }
    if (isset($_SESSION['change_password_success'])) {
        if ($_SESSION['change_password_success'] == "password_updated") {
            echo '<div id="login-section" class="section animate">
                        <div id="notification" class="notification is-info has-text-centered">';
                            echo '<p>A <strong>new password</strong> has been updated</p>';
                            unset($_SESSION['change_password_success']);
                            echo '
                        </div>
                 </div>';
        }
    }
}

if (isset($_SESSION['mail_password_send'])) {
    echo '<div id="login-section" class="section animate">
					<div id="notification" class="notification is-danger has-text-centered">';
    if ($_SESSION['mail_password_send'] == "waiting")
        echo '	<p>A <strong>new</strong> password reset link has been sent.</p>';
    else if ($_SESSION['mail_password_send'] == "error")
        echo '	<p>An <strong>error</strong> occured. Username and Mail are not associated.</p>';
    unset($_SESSION['mail_password_send']);
    echo '</div>
				</div>';
}




if (isset($_SESSION['mail_success'])) {
    echo '<div id="login-section" class="section animate">
				    <div id="notification" class="notification is-info has-text-centered">';

    if ($_SESSION['mail_success'] == "resend") {
        echo '<p>A <strong>new</strong> mail confirmation has been sent to the provided email address.</p><strong>Please confirm to use your account.</strong></br>';
    }
    if ($_SESSION['mail_success'] == "waiting") {
        echo '<p>A mail confirmation has been sent to the provided email address.</p><strong>Please confirm to use your account.</strong></br>';
    }
    if ($_SESSION['mail_success'] == "max_links") {
        echo '<p><strong>Too much links were send.</strong></p>';
    }

    if ($_SESSION['mail_success'] == "success") {
        echo '<p>Your <strong>Camagru account</strong> was successfully activated !</strong></br>';
    }
    unset($_SESSION['mail_success']);

    echo '</div>
                    </div>';
}