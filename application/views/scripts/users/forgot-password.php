<?php
$pageTitle = __('Forgot Password');
head(array('title' => $pageTitle, 'bodyclass' => 'login'), $header);
?>
<style>
    #loginform .textinput{
        width:100px !important;
    }
    #loginform .inputs{
        width:150px !important;
    }
</style>
<div style=" float: left; width: 340px; margin-left: 20px;" id="loginform">
<h1><?php echo $pageTitle; ?></h1>
<p id="login-links">
<span id="backtologin"><?php echo link_to('users', 'login', __('Back to Log In')); ?></span>
</p>

<p class="clear"><?php echo __('Enter your email address to retrieve your password.'); ?></p>
<?php echo flash(); ?>
<form method="post" accept-charset="utf-8">
    <div class="field">        
        <label for="email"><?php echo __('Email'); ?></label>
        <?php echo $this->formText('email', @$_POST['email'], array('class'=>'textinput')); ?>
    </div>

    <input type="submit" class="submit" value="<?php echo __('Submit'); ?>" />
</form>
</div>
<?php foot(array(), $footer); ?>
