<?php

namespace Com\Daw2\Controllers;


class IndexController extends \Com\Daw2\Core\BaseController {

    public function index() {
        
        $this->view->show('index.view.php');
    }
}
