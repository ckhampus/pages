<?php

namespace Pages\Admin\Controllers;

class LayoutControllerProvider extends ResourceControllerProvider
{
    public function getResourceClass()
    {
        return 'Pages\\Entities\\Layout';
    }
}
