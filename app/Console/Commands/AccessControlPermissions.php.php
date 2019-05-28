<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AccessControlPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update roles and permission due to config';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Truncating Role and Permission tables');
        $this->truncateLaratrustTables();

        $roles         = config('laratrust_seeder.role_structure');
        $role_user     = config('laratrust.tables.role_user');
        $user_models   = config('laratrust.user_models.users');
        $access_levels = config('laratrust_seeder.access_levels');

        \Eloquent::unguard();
        foreach ($roles as $roleName => $perm) {
            $roleDisplayName = ucwords(str_replace(['_', 'customer'], [' ', 'member'], $roleName));
            $role = Role::updateOrCreate(
                ['name' => $roleName],
                [
                    'display_name' => $roleDisplayName,
                    'description'  => $roleDisplayName,
                    'level'        => $access_levels[$roleName]
                ]);
            $permissions = [];
            $this->info("Updating permissions for $roleName", 1);
//            foreach ($perm as $permission) {
////                $title         = ucfirst(str_replace(['.', 'account'], [' ', 'admin'] , $permission));
//                $permissions[] = Permission::firstOrCreate(
//                    ['name' => $roleName],
//                    [
//                        'display_name' => $roleName,
//                        'description'  => $roleName
//                    ])->id;
//
//                $this->info("Creating Permission to $permission for $roleName", 'v');
//            }
//
//            // Attach all permissions to the role
//            $role->permissions()->sync($permissions);

            // Update roles models bindings
            $this->info("Updating user roles model bindings to $user_models", 'v');
            DB::table($role_user)->update([
                'user_type' => $user_models
            ]);
        }
    }

    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
