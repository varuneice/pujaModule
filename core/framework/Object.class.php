<?php
class GzObject {

    function loadFiles($type, $name) {
        $type = strtolower($type);
        if (!in_array($type, array('model', 'component'))) {
            return false;
        }

        switch ($type) {
            case 'model':
                if (is_array($name)) {
                    foreach ($name as $n) {
                        require_once MODELS_PATH . $n . '.model.php';
                    }
                } else {
                    require_once MODELS_PATH . $name . '.model.php';
                }
                break;
            case 'component':
                if (is_array($name)) {
                    foreach ($name as $n) {
                        require_once COMPONENTS_PATH . $n . '.php';
                    }
                } else {

                    require_once COMPONENTS_PATH . $name . '.php';
                }
                break;
        }
        return;
    }

}