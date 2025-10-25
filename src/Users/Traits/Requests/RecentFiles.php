<?php

namespace Enraiged\Users\Traits\Requests;

use Enraiged\Files\Resources\FileResource;
use Illuminate\Http\Request;

trait RecentFiles
{
    /** @var  int  The number of files to show. */
    public $limit = 3;

    /**
     *  Return a list of recent files, if possible.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @return array|null
     */
    private function recentFiles(Request $request)
    {
        if ($request->user()) {
            $files = $request->user()
                ->files()
                ->where('created_at', '>', date('Y-m-d 00:00:00'))
                ->orderBy('created_at', 'desc')
                ->limit($this->limit);

            return FileResource::collection($files->get())->all();
        }

        return null;
    }
}
