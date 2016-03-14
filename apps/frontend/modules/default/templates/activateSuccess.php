<div id="content_div" data-redirect_url="<?php echo url_for("homepage"); ?>" class="contentMiddle clear">
    <!-- start: leftContent -->
    <div class="leftContent">
        <div class="smiley"></div>
    </div>
    <!-- end: leftContent -->
    <!-- start: contentMiddle -->
    <div class="rightContent" style="margin: 44.5px 0px;">
        <h1 style="color: #55DD00;">Your user has been activated!!</h1>
        <h3>Now you are ready to use the application!</h3>
        <ul>
            <li>You will be redirected to the login page in about 5 seconds.</li>
        </ul>

        <div class="space20"></div>
    </div>
    <!-- end: contentMiddle -->
</div>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            window.location.replace($("#content_div").data("redirect_url"));
        }, 5000);
    });
</script>