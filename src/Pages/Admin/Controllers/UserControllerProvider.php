<?php

namespace Pages\Admin\Controllers;

class UserControllerProvider extends ResourceControllerProvider
{
    public function getResourceClass()
    {
        return 'Pages\\Entities\\User';
    }
}
