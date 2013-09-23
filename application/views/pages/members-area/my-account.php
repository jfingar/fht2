<div class="members-area-top">
    <h1 class="members-area-heading">
        Account Settings
    </h1>
    <div class="clear"></div>
</div>

<form id="member-data">
    <div class="member-data-input-container">
        <label>First Name</label>
        <input type="text" class="text-input-1" id="firstName" name="firstName" value="<?= $this->user->getFirstName(); ?>" />
    </div>
    <div class="member-data-input-container">
        <label>Last Name</label>
        <input type="text" class="text-input-1" id="lastName" name="lastName" value="<?= $this->user->getLastName(); ?>" />
    </div>
    <div class="clear"></div>
    <div class="member-data-input-container">
        <label>Email Address</label>
        <input type="text" class="text-input-1" id="email" name="email" value="<?= $this->user->getEmail(); ?>" />
    </div>
    <div class="clear"></div>
    <input type="submit" value="Save Changes" id="member-data-submit" />
</form>

<a id="show-update-pw">CHANGE PASSWORD</a>