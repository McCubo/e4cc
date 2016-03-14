<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" href="<?php echo url_for("@homepage") ?>"><?php echo sfConfig::get('app_tmcTwitterBootstrapPlugin_dashboard_name', 'Administration') ?></a>
            <?php if ($sf_user->getAttribute("has_access") == true): ?>
                <div class="nav-collapse">
                    <p class="navbar-text pull-right"><a href="<?php echo url_for("home/logout"); ?>">Logout</a></p>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>