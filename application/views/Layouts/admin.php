<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HDBS</title>
          <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
        <?php
        $user = $this->controller->getUser();
        foreach ($this->controller->css as $css) {
            echo '<link type="text/css" rel="stylesheet" href="' . (isset($css['remote']) && $css['remote'] ? NULL : INSTALL_URL) . $css['path'] . $css['file'] . '" />';
        }
        foreach ($this->controller->js as $js) {
            echo '<script type="text/javascript" src="' . (isset($js['remote']) && $js['remote'] ? NULL : INSTALL_URL) . $js['path'] . $js['file'] . '"></script>';
        }
        ?>
    </head>
    <body class="skin-blue">
        <header class="header">
        <?php 
         if($this->controller->isLoged()){
        if ($this->controller->isAdmin()) { ?>
            <a href="#" class="logo" title="HDBS-PAYMENT|Booking System">
            HDBS Payment
            </a>
          <?php }else if($this->controller->isEditor()) { ?>
            <a href="#" class="logo" title="HDBS-PAYMENT|Booking System">
            Dashboard
            </a>
             <?php }
           else if($this->controller->isViewer() || $this->controller->isMerchandiseViewer() || $this->controller->isMerchandiseEditor()) { ?>
                <a href="#" class="logo" title="HDBS-PAYMENT|Puja System">
                Dashboard
                </a>
            <?php }else{ ?>
                <a href="#" class="logo" title="HDBS-PAYMENT|Booking System">
                Member Dashboard
                </a>
                <?php } 
           
            require_once VIEWS_PATH . 'Layouts/admin/menu/navbar_static_top.php';
            }
         ?>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left" id="gz-time-slot-booking-container-id">
            <?php
            if($this->controller->isLoged()){
                require_once VIEWS_PATH . 'Layouts/admin/menu/sidebar.php';
            }
            ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side <?php echo (!$this->controller->isLoged())?"strech":""; ?>">
                <?php
                require $content_tpl;
                ?>
            </aside><!-- /.right-side -->
            <a class="btn btn-icon btn-info btn-scroll-to-top fade" data-click="scroll-top" href="javascript:;">
                <i class="fa fa-angle-up"></i>
            </a>
            <?php
            require_once VIEWS_PATH . 'Layouts/admin/footer.php';
            ?>
        </div>
        <div id="container-abc-url-id" style="display: none;"><?php echo INSTALL_URL; ?></div>
    </div>
<?php if (!empty($_SESSION['csrf_token'])): ?>
<script>
(function() {
    var token = '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES); ?>';
    // Inject CSRF hidden field into every POST form that doesn't already have one
    var forms = document.querySelectorAll('form');
    for (var i = 0; i < forms.length; i++) {
        var m = (forms[i].getAttribute('method') || '').toLowerCase();
        if (m === 'post' && !forms[i].querySelector('input[name="csrf_token"]')) {
            var inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = 'csrf_token'; inp.value = token;
            forms[i].appendChild(inp);
        }
    }
    // Inject CSRF token into all jQuery AJAX POST requests
    if (window.jQuery) {
        jQuery(document).ajaxSend(function(evt, xhr, settings) {
            if ((settings.type || '').toUpperCase() === 'POST') {
                xhr.setRequestHeader('X-CSRF-Token', token);
                if (typeof settings.data === 'string') {
                    settings.data += (settings.data ? '&' : '') + 'csrf_token=' + encodeURIComponent(token);
                } else if (settings.data && typeof settings.data === 'object' && !(settings.data instanceof FormData)) {
                    settings.data.csrf_token = token;
                }
            }
        });
    }
})();
</script>
<?php endif; ?>


