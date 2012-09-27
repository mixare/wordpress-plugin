<?php

//retrieve handler of life cycle
require_once MIXAREPOI_DIR.'/install/class-mixarepoi-lifecycle-handler.php';

//adding the HOOKS for the entry points of handler
register_activation_hook(MIXAREPOI__FILE__, 'Mixarepoi_Lifecycle_Handler::active_cb');
register_deactivation_hook(MIXAREPOI__FILE__, 'Mixarepoi_Lifecycle_Handler::deactive_cb');
register_uninstall_hook(MIXAREPOI__FILE__, 'Mixarepoi_Lifecycle_Handler::unistall_cb');



?>