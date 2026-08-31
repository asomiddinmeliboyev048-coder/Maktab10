<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Yagona joy — bu yerga yangi modul qo'shilsa, permissionlar
     * avtomatik yaratiladi. Boshqa hech qanday joyda modul nomlari
     * hardcode qilinmaydi.
     */
    public function run()
    {
        $modules = [
            'students'  => 'O\'quvchilar',
            'classes'   => 'Sinflar',
            'teachers'  => 'O\'qituvchilar',
            'schedule'  => 'Dars jadvali',
            'library'   => 'Kutubxona',
            'attendance'=> 'Davomat',
            'grades'    => 'Baholar',
            'statistics'=> 'Statistika',
            'ranking'   => 'O\'quvchilar reytingi',
            'messages'  => 'Xabarlar',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module => $moduleName) {
            foreach ($actions as $action) {
                Permission::updateOrCreate(
                    ['slug' => $module . '.' . $action],
                    [
                        'module' => $module,
                        'module_name' => $moduleName,
                        'action' => $action,
                    ]
                );
            }
        }
    }
}