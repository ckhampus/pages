<?php

namespace Pages\Admin\Controllers;

class ColumnControllerProvider extends ResourceControllerProvider
{
    public function getResourceClass()
    {
        return 'Pages\\Entities\\Column';
    }
}
