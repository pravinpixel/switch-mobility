<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $datas = [
            [
               'name'=>'department-view',
               'guard_name'=>'web'   
            ],
            [
                'name'=>'department-create',
                'guard_name'=>'web'   
            ], [
                'name'=>'department-edit',
                'guard_name'=>'web'   
            ],
            [
                'name'=>'department-delete',
                'guard_name'=>'web'   
            ],            
             [
                'name'=>'department-upload',
                'guard_name'=>'web'   
             ], [
                'name'=>'department-download',
                'guard_name'=>'web'   
             ],
//designation
             [
                'name'=>'designation-view',
                'guard_name'=>'web'   
             ],
             [
                 'name'=>'designation-create',
                 'guard_name'=>'web'   
             ], [
                 'name'=>'designation-edit',
                 'guard_name'=>'web'   
             ],
             [
                'name'=>'designation-delete',
                'guard_name'=>'web'   
            ],
              [
                 'name'=>'designation-upload',
                 'guard_name'=>'web'   
              ], [
                 'name'=>'designation-download',
                 'guard_name'=>'web'   
              ],

              [
                'name'=>'document-type-view',
                'guard_name'=>'web'   
             ],
             [
                 'name'=>'document-type-create',
                 'guard_name'=>'web'   
             ], [
                 'name'=>'document-type-edit',
                 'guard_name'=>'web'   
             ],
             [
                'name'=>'document-type-delete',
                'guard_name'=>'web'   
            ],
              [
                 'name'=>'document-type-upload',
                 'guard_name'=>'web'   
              ], [
                 'name'=>'document-type-download',
                 'guard_name'=>'web'   
              ],
              
              [
                'name'=>'employee-view',
                'guard_name'=>'web'   
             ],
             [
                 'name'=>'employee-create',
                 'guard_name'=>'web'   
             ], [
                 'name'=>'employee-edit',
                 'guard_name'=>'web'   
             ],
             [
                'name'=>'employee-delete',
                'guard_name'=>'web'   
            ],
              [
                 'name'=>'employee-upload',
                 'guard_name'=>'web'   
              ], [
                 'name'=>'employee-download',
                 'guard_name'=>'web'   
              ],

              [
                'name'=>'workflow-view',
                'guard_name'=>'web'   
             ],
             [
                 'name'=>'workflow-create',
                 'guard_name'=>'web'   
             ], [
                 'name'=>'workflow-edit',
                 'guard_name'=>'web'   
             ],
             [
                'name'=>'workflow-delete',
                'guard_name'=>'web'   
            ],
              [
                 'name'=>'workflow-upload',
                 'guard_name'=>'web'   
              ], [
                 'name'=>'workflow-download',
                 'guard_name'=>'web'   
              ],

              [
                'name'=>'project-view',
                'guard_name'=>'web'   
             ],
             [
                 'name'=>'project-create',
                 'guard_name'=>'web'   
             ], [
                 'name'=>'project-edit',
                 'guard_name'=>'web'   
             ],
             [
                'name'=>'project-delete',
                'guard_name'=>'web'   
            ],
              [
                 'name'=>'project-upload',
                 'guard_name'=>'web'   
              ], [
                 'name'=>'project-download',
                 'guard_name'=>'web'   
              ],

              [
                'name'=>'role-view',
                'guard_name'=>'web'   
             ],
             [
                 'name'=>'role-create',
                 'guard_name'=>'web'   
             ], [
                 'name'=>'role-edit',
                 'guard_name'=>'web'   
             ], [
                'name'=>'role-delete',
                'guard_name'=>'web'   
            ],
              [
                 'name'=>'role-upload',
                 'guard_name'=>'web'   
              ], [
                 'name'=>'role-download',
                 'guard_name'=>'web'   
              ],

              [
                'name'=>'user-view',
                'guard_name'=>'web'   
             ],
             [
                 'name'=>'user-create',
                 'guard_name'=>'web'   
             ], [
                 'name'=>'user-edit',
                 'guard_name'=>'web'   
             ],
             [
                'name'=>'user-delete',
                'guard_name'=>'web'   
            ],
              [
                 'name'=>'user-upload',
                 'guard_name'=>'web'   
              ], [
                 'name'=>'user-download',
                 'guard_name'=>'web'   
              ],

        ];
  
        foreach ($datas as $key => $value) {
            Permission::create($value);
        }
    }
}
