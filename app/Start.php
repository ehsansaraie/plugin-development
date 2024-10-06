<?php

namespace FalconBaseServices;

use FalconBaseServices\Services\AdminDisplay;
use FalconBaseServices\Services\CustomMetaBox;
use FalconBaseServices\Services\CustomPostType;

class Start
{
    public function __construct()
    {
        new Routes();
        $this->actionHandler();
        $this->filterHandler();
    }

    public function filterHandler() {}

    public function actionHandler() 
    {
        // Custom Post Type
        $customPostTypeService = new CustomPostType();
        $customPostTypeService->register();
        
        // Custom MetaBox
        $CustomMetaBoxService = new CustomMetaBox();
        $CustomMetaBoxService->register();

        // Admin Display
        $adminDisplayService = new AdminDisplay();
        $adminDisplayService->register();
    }
}
