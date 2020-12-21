<?php
use Illuminate\Database\Seeder;
class ProjectModule extends Seeder
{
  public function run()
  {
    DB::table('project_modules')->truncate();
    $data=[];
    // $data[]=['module' => 'Reminders','sub_module'=>'Reminders'  ];
    $data[]=['module' => 'User','sub_module'=>'User'  ];
    $data[]=['module' => 'User','sub_module'=>'Profile'  ];
    $data[]=['module' => 'User','sub_module'=>'UserTypePrivileges'  ];
    $data[]=['module' => 'User','sub_module'=>'UserList'  ];
    $data[]=['module' => 'User','sub_module'=>'UserTypes'  ];
    // $data[]=['module' => 'Tasks','sub_module'=>'Tasks'  ];
    // $data[]=['module' => 'Tasks','sub_module'=>'Calender'  ];
    $data[]=['module' => 'Settings','sub_module'=>'Download'  ];
    $data[]=['module' => 'Settings','sub_module'=>'Settings'  ];
    $data[]=['module' => 'Settings','sub_module'=>'Country'  ];
    $data[]=['module' => 'Settings','sub_module'=>'DocumentType'  ];
    $data[]=['module' => 'Employees','sub_module'=>'Employee'  ];
    // $data[]=['module' => 'Employees','sub_module'=>'Documents'  ];
    // $data[]=['module' => 'languages','sub_module'=>'languages'  ];
    $data[]=['module' => 'Beacons','sub_module'=>'Beacons'  ];
    $data[]=['module' => 'Beacons','sub_module'=>'Beacon'  ];
    
    $data[]=['module' => 'Log','sub_module'=>'Log'  ];
    $data[]=['module' => 'CheckList','sub_module'=>'CheckList'  ];
    $data[]=['module' => 'Situations','sub_module'=>'Situations'  ];
    $data[]=['module' => 'Situations','sub_module'=>'Situation'  ];
    
    $data[]=['module' => 'Beacons','sub_module'=>'BeaconEdit'  ];
    DB::table('project_modules')->insert($data);
  }
}
