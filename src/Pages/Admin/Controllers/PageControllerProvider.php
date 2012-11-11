<?php

namespace Pages\Admin\Controllers;

class PageControllerProvider extends ResourceControllerProvider
{
    public function getResourceClass()
    {
        return 'Pages\Entities\Page';
    }
}
