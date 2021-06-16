<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{   

    public function Permission()
    {   
    	$dev_permission = Permission::where('slug','create-tasks')->first();
		$manager_permission = Permission::where('slug', 'edit-users')->first();

		//RoleTableSeeder.php
		
		$manager_role = new Role();
		$manager_role->slug = 'admin';
		$manager_role->name = 'Super Admin';
		$manager_role->save();
		$manager_role->permissions()->attach($manager_permission);
		
		$dev_role = new Role();
		$dev_role->slug = 'editor';
		$dev_role->name = 'Editor';
		$dev_role->save();
		$dev_role->permissions()->attach($dev_permission);

		$dev_role = Role::where('slug','editor')->first();
		$manager_role = Role::where('slug', 'admin')->first();

		$createTasks = new Permission();
		$createTasks->slug = 'create-tasks';
		$createTasks->name = 'Create Tasks';
		$createTasks->save();
		$createTasks->roles()->attach($dev_role);

		$editUsers = new Permission();
		$editUsers->slug = 'edit-users';
		$editUsers->name = 'Edit Users';
		$editUsers->save();
		$editUsers->roles()->attach($manager_role);

		$dev_role = Role::where('slug','editor')->first();
		$manager_role = Role::where('slug', 'admin')->first();
		$dev_perm = Permission::where('slug','create-tasks')->first();
		$manager_perm = Permission::where('slug','edit-users')->first();

		$manager = new User();
		$manager->name = 'Super Admin';
		$manager->email = 'admin@gmail.com';
		$manager->password = bcrypt('secrettt');
		$manager->save();
		$manager->roles()->attach($manager_role);
		$manager->permissions()->attach($manager_perm);
		
		$developer = new User();
		$developer->name = 'Editor';
		$developer->email = 'editor@gmail.com';
		$developer->password = bcrypt('secrettt');
		$developer->save();
		$developer->roles()->attach($dev_role);
		$developer->permissions()->attach($dev_perm);

		return redirect()->back();
    }
}

