<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = config('roles');

        foreach ($roles as $role => $permissions) {
            $created_role = \App\Role::updateOrCreate(['name' => $role], ['name' => $role]);
            $permissions_ids = [];
            foreach ($permissions as $permission) {
                $controller = $permission['controller'];
                $method = $permission['method'];
                try {
                    $permission = \App\Permission::where('controller', 'like', '%' . $controller . '%')->where('method', 'like', '%' . $method . '%')->firstOrFail();
                } catch (Exception $exception) {
                    print_r("\e[0;31mRoute for " . $controller . '=>' . $method . " does not exist\e[0m\n");
                    print_r("\e[0;31mSTOP SEEDING\e[0m\n");
                    die();
                }
                array_push($permissions_ids, $permission->id);
            }
            $created_role->permissions()->sync($permissions_ids);
        }

        $permissions_not_used = \App\Permission::select(['controller','method'])->doesntHave('roles')->get()->toArray();
        if (count($permissions_not_used)) {
            if (count($permissions_not_used) === 1) {
                print_r("\e[0;31mThis permission doesn't have related roles!\e[0m\n");
                dump($permissions_not_used[0]);
            } else {
                print_r("\e[0;31mThese permissions don't have related roles!\e[0m\n");
                dump($permissions_not_used);
            }
            $seconds = 5;
            while ($seconds > 0) {
                print_r("Continue seeding in " . $seconds . " second" . ($seconds === 1 ? " " : "s") . "\r");
                $seconds--;
                sleep(1);
            }
            print_r("                              \n");
        }
    }
}
