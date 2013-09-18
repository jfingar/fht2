<? if(isset($this->invalidPwReset)) : ?>
    <p class="pw-reset-fail">
        This password reset instance is invalid or has expired. Please visit <a href="/index">the homepage</a> and click on the "Forgot Password" link.
    </p>
<? else : ?>
    <div class="form-wrapper-container">
        <form class="standardForm" id="resetPwForm" action="/reset-pw-action" method="post">
            <div class="form-heading">Reset Your Password</div>
            <div>
                <label>New Password</label>
                <input name="pw1" type="password" class="text-input-1" />
            </div>
            <div>
                <label>Re-Type New Password</label>
                <input name="pw2" type="password" class="text-input-1" />
            </div>
            <div id="resetPwSubmitContainer" class="submitContainer">
                <input type="submit" value="Reset Password" class="submit-input-1" />
            </div>
            <div class="ajaxResponseContainer hidden">
            </div>
            <input type="hidden" name="email" value="<?= $_GET['email']; ?>" />
            <input type="hidden" name="hash" value="<?= $_GET['hash']; ?>" />
        </form>
    </div>
<? endif; ?>
