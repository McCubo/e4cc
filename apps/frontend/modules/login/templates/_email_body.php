<h1>Hi <?php echo $oPerson->getFullName(); ?>!</h1>
<p>
    We have recently received a request to create an account with this email, If this was you, then you 
    are just one step away from getting your account activated and ready to use it in the system, 
    just by clicking the link at the bottom of this email.
    <br />
    <strong>If you did not requested an account, please delete this email.</strong>
</p>
<strong>Link: </strong> 
<br />
<?php echo $sUrl; ?>
<br />