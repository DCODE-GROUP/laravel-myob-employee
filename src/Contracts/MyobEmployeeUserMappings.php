<?php

namespace Dcodegroup\LaravelMyobEmployee\Contracts;

interface MyobEmployeeUserMappings
{
    /**
     * This method must be implemented in order to have a consistent field to display the name of a user
     * the name may be a combination of fields or have different names between apps
     *
     * @return string
     */
    public function getMyobEmployeeNameAttribute(): string;
}
