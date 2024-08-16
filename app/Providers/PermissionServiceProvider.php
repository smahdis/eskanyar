<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $permissions = ItemPermission::group('زائرسرا')
            ->addPermission('see_pilgrim_groups', 'نمایش گروهها')
            ->addPermission('edit_pilgrim_groups', 'ویرایش گروه ها')
            ->addPermission('see_places', 'نمایش اسکان')
            ->addPermission('edit_places', 'ویرایش اسکان');

        $dashboard->registerPermissions($permissions);


    }
}
