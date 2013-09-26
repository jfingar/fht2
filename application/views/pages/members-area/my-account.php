<div class="members-area-top">
    <h1 class="members-area-heading">
        Account Settings
    </h1>
    <div class="clear"></div>
</div>

<div class="form-wrapper-container twoColumn">
    <form class="standardForm" id="memberDataForm" action="/members-area/update-member-data" method="post">
        <div class="form-heading">Update Your Information</div>
        <div class="floatLeft">
            <label>First Name</label>
            <input name="firstName" id="firstName" type="text" class="text-input-1" value="<?= $this->user->getFirstName(); ?>" />
        </div>
        <div class="floatLeft rightCol">
            <label>Last Name</label>
            <input name="lastName" id="lastName" type="text" class="text-input-1" value="<?= $this->user->getLastName(); ?>" />
        </div>
        <div class="floatLeft">
            <label>Email Address</label>
            <input name="email" id="email" type="text" class="text-input-1" value="<?= $this->user->getEmail(); ?>" />
        </div>
        <div id="loginSubmitContainer" class="submitContainer floatLeft" style="padding: 23px 0px 0px 55px;">
            <input type="submit" value="Save Changes" id="member-data-submit" />
        </div>
        <div class="clear"></div>
        <div class="ajaxResponseContainer hidden">
        </div>
        <div class="clear"></div>
    </form>
</div>
<div class="clear"></div>
<div id="more-account-opts">
    <a id="show-update-pw">CHANGE PASSWORD</a>
    <a id="delete-account">DELETE MY ACCOUNT</a>
</div>