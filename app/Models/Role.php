<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{

	public $appends = ['initial'];

    private $initialRoles;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->initialRoles = config('laratrust_seeder.role_structure');
    }

    /**
     * Check if role is initial
     *
     * @return boolean
     */
    public function getInitialAttribute()
    {
        if ($this && $this->name) {
            return !empty($this->initialRoles[$this->name]);
        }
    }
}