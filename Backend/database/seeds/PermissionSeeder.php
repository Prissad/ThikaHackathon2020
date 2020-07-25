<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // iterate though all routes
        foreach (Route::getRoutes()->getRoutes() as $key => $route) {
            if (!in_array('auth:api', $route->gatherMiddleware(), true)) {
                continue;
            }
            // get route action
            $action = $route->getActionname();
            // separating controller and method
            $_action = explode('@', $action);

            // get controller
            $controller = $_action[0];
//            print_r('controller : ' . $controller . "\n");

            // check if controller should have permission
            if (!strcmp($controller, 'Closure') || strpos($controller, 'ApiTester'))
                continue;

            //get method
            $method = end($_action);
//            print_r($method . "\n");

            // check if this permission is already exists
            $permission_check = Permission::where(
                ['controller' => $controller, 'method' => $method]
            )->first();
            if (!$permission_check) {
                $permission = new Permission;
                $permission->controller = $controller;
                $permission->method = $method;
                $permission->save();
            }
        }
    }
}
