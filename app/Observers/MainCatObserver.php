<?php

namespace App\Observers;

use App\Models\MainCategory;

class MainCatObserver
{
    /**
     * Handle the main category "created" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function created(MainCategory $mainCategory)
    {
        //
    }

    /**
     * Handle the main category "updated" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function updated(MainCategory $mainCategory)
    {
        if ($mainCategory->vendors()->count() > 0)
        {
            if($mainCategory -> active == 0)
                $mainCategory->vendors()->update(['commented' => 1]);
            else
                $mainCategory->vendors()->update(['commented' => 0]);
        }
    }

    /**
     * Handle the main category "deleted" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function deleted(MainCategory $mainCategory)
    {
        $mainCategory->categories()->delete();
    }

    /**
     * Handle the main category "restored" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function restored(MainCategory $mainCategory)
    {
        //
    }

    /**
     * Handle the main category "force deleted" event.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return void
     */
    public function forceDeleted(MainCategory $mainCategory)
    {
        //
    }
}
