<h1>Hi <?php echo $oPerson->getFullName(); ?>!</h1>
<p>
    We have recently received a request to change your account password, If this 
    was you, then you are just one step away from reset your password and ready to use 
    it in the system, just by clicking the link at the bottom of this email.
    <br />
    <strong>If you did not requested an account, please delete this email.</strong>
</p>
<strong>Link: </strong> 
<br />
<?php echo $sUrl; ?>
<br />
<br />
<small>The link above will expire in 7 days, use it before <?php echo date("l jS,  F (Y)", strtotime("+7 days")); ?></small>