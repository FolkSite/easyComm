<form class="form well ec-form" method="post" role="form" id="ec-form-[[+fid]]" data-fid="[[+fid]]" action="">
    <input type="hidden" name="thread" value="[[+thread]]">

    <div class="form-group">
        <label for="ec-user_name-[[+fid]]" class="control-label">[[%ec_fe_message_user_name]]</label>
        <input type="text" name="user_name" class="form-control" id="ec-user_name-[[+fid]]" value="[[+user_name]]" />
        <span class="ec-error help-block" id="ec-user_name-error-[[+fid]]"></span>
    </div>

    <div class="form-group">
        <label for="ec-user_email-[[+fid]]" class="control-label">[[%ec_fe_message_user_email]]</label>
        <input type="text" name="user_email" class="form-control" id="ec-user_email-[[+fid]]" value="[[+user_email]]" />
        <span class="ec-error help-block" id="ec-user_email-error-[[+fid]]"></span>
    </div>

    <div class="form-group">
        <label for="ec-user_contacts-[[+fid]]" class="control-label">[[%ec_fe_message_user_contacts]]</label>
        <input type="text" name="user_contacts" class="form-control" id="ec-user_contacts-[[+fid]]" value="[[+user_contacts]]" />
        <span class="ec-error help-block" id="ec-user_contacts-error-[[+fid]]"></span>
    </div>

    <div class="form-group">
        <label for="ec-subject-[[+fid]]" class="control-label">[[%ec_fe_message_subject]]</label>
        <input type="text" name="subject" class="form-control" id="ec-subject-[[+fid]]" value="[[+subject]]" />
        <span class="ec-error help-block" id="ec-subject-error-[[+fid]]"></span>
    </div>

    <div class="form-group">
        <label for="ec-text-[[+fid]]" class="control-label">[[%ec_fe_message_text]]</label>
        <textarea type="text" name="text" class="form-control" rows="5" id="ec-text-[[+fid]]">[[+text]]</textarea>
        <span class="ec-error help-block" id="ec-text-error-[[+fid]]"></span>
    </div>

    <div class="form-actions">
        <input type="submit" class="btn btn-primary" name="send" value="[[%ec_fe_send]]" />
    </div>
</form>
<div id="ec-form-success-[[+fid]]"></div>