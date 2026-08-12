<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'users' => [
                'actions' => [
                    'index' => 'admin.user.index',
                    'create'  => 'admin.user.create',
                    'edit'    => 'admin.user.edit',
                    'trash' => 'admin.user.destroy',
                    'restore' => 'admin.user.restore',
                    'delete' => 'admin.user.forceDelete'
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'create', 'edit', 'trash', 'restore', 'destroy'],
                ]
            ],
            'roles' => [
                'actions' => [
                    'index'   => 'role.index',
                    'create'  => 'role.create',
                    'edit'    => 'role.edit',
                    'delete'  => 'role.destroy'
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'create', 'edit', 'delete'],
                ],
            ],
            'attachments' => [
                'actions' => [
                    'index'   => 'attachment.index',
                    'create'  => 'attachment.create',
                    'delete'  => 'attachment.destroy'
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'create', 'delete'],
                    RoleEnum::STAFF => ['index', 'create', 'delete'],
                    RoleEnum::AUTHOR => ['index', 'create', 'delete'],
                    RoleEnum::MEMBER => ['index', 'create', 'delete'],
                    RoleEnum::CREATOR => ['index', 'create', 'delete'],
                ],
            ],
            'categories' => [
                'actions' => [
                    'index'   => 'category.index',
                    'create'  => 'category.create',
                    'edit'    => 'category.edit',
                    'delete'  => 'category.destroy'
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'create', 'edit', 'delete'],
                    RoleEnum::USER => ['index', 'create', 'edit', 'destroy'],
                    RoleEnum::STAFF => ['index', 'create', 'edit', 'destroy'],
                    RoleEnum::AUTHOR => ['index', 'create', 'edit', 'destroy'],
                    RoleEnum::MEMBER => ['index', 'create', 'edit', 'destroy'],
                    RoleEnum::CREATOR => ['index', 'create', 'edit', 'destroy'],
                ]
            ],
            'tags' => [
                'actions' => [
                    'index'   => 'admin.tag.index',
                    'create'  => 'admin.tag.create',
                    'edit'    => 'admin.tag.edit',
                    'trash'   => 'admin.tag.destroy',
                    'restore' => 'admin.tag.restore',
                    'delete'  => 'admin.tag.forceDelete'
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'create', 'edit', 'trash', 'restore', 'delete'],
                    RoleEnum::USER => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::STAFF => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::AUTHOR => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::MEMBER => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::CREATOR => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                ]
            ],
            'blogs' => [
                'actions' => [
                    'index'   => 'admin.blog.index',
                    'create'  => 'admin.blog.create',
                    'edit'    => 'admin.blog.edit',
                    'trash'   => 'admin.blog.destroy',
                    'restore' => 'admin.blog.restore',
                    'delete'  => 'admin.blog.forceDelete'
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'create', 'edit', 'trash', 'restore', 'delete'],
                    RoleEnum::USER => ['index', 'create', 'edit', 'forceDelete'],
                    RoleEnum::STAFF => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::AUTHOR => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::MEMBER => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::CREATOR => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                ]
            ],
            'pages' => [
                'actions' => [
                    'index'   => 'page.index',
                    'create'  => 'page.create',
                    'edit'    => 'page.edit',
                    'trash'   => 'page.destroy',
                    'restore' => 'page.restore',
                    'delete'  => 'page.forceDelete'
                ],
                'roles' => [
                    RoleEnum::ADMIN => ['index', 'create', 'edit', 'trash', 'restore', 'delete'],
                    RoleEnum::USER => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::STAFF => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::AUTHOR => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::MEMBER => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                    RoleEnum::CREATOR => ['index', 'create', 'edit', 'destroy', 'restore', 'forceDelete'],
                ]
            ],
        ];

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $userpermision = [];
        $staffpermision = [];
        $authorpermision = [];
        $memberpermision = [];
        $creatorpermision = [];

        foreach ($modules as $key => $value) {
            Module::updateOrCreate(['name' => $key], ['name' => $key, 'actions' => $value['actions']]);
            foreach ($value['actions'] as $key => $permission) {
                if (!Permission::where('name', $permission)->first()) {
                    $permission = Permission::create(['name' => $permission]);
                }
                if (isset($value['roles'])) {
                    foreach ($value['roles'] as $role => $allowed_actions) {
                        if ($role == RoleEnum::USER) {
                            if (in_array($key, $allowed_actions)) {
                                $userpermision[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::STAFF) {
                            if (in_array($key, $allowed_actions)) {
                                $staffpermision[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::AUTHOR) {
                            if (in_array($key, $allowed_actions)) {
                                $authorpermision[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::MEMBER) {
                            if (in_array($key, $allowed_actions)) {
                                $memberpermision[] = $permission;
                            }
                        }
                        if ($role == RoleEnum::CREATOR) {
                            if (in_array($key, $allowed_actions)) {
                                $creatorpermision[] = $permission;
                            }
                        }
                    }
                }
            }
        }


        $admin = Role::create([
            'name' => RoleEnum::ADMIN,
            'system_reserve' => true
        ]);
        $admin->givePermissionTo(Permission::all());
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'status' => true,
            'group_id' => 1
        ]);
        $user->assignRole($admin);
    }
}
