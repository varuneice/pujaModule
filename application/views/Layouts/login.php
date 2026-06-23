<?php

foreach ($this->controller->css as $css) {
    echo '<link type="text/css" rel="stylesheet" href="' . (isset($css['remote']) && $css['remote'] ? NULL : INSTALL_URL) . $css['path'] . $css['file'] . '" />';
}
foreach ($this->controller->js as $js) {
    echo '<script type="text/javascript" src="' . (isset($js['remote']) && $js['remote'] ? NULL : INSTALL_URL) . $js['path'] . $js['file'] . '"></script>';
}
require $content_tpl;
?>
<div id="container-abc-url-id" style="display: none;"><?php echo INSTALL_URL; ?></div>
<?php if (!empty($_SESSION['csrf_token'])): ?>
<script>
(function() {
    var token = '<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES); ?>';
    var forms = document.querySelectorAll('form');
    for (var i = 0; i < forms.length; i++) {
        var m = (forms[i].getAttribute('method') || '').toLowerCase();
        if (m === 'post' && !forms[i].querySelector('input[name="csrf_token"]')) {
            var inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = 'csrf_token'; inp.value = token;
            forms[i].appendChild(inp);
        }
    }
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