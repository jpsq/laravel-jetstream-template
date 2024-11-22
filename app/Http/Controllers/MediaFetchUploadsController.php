<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaFetchUploadsController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $records = Media::latest('created_at')
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->query('keyword', '')}%")
                    ->orWhere('mime_type', 'like', "%{$request->query('keyword', '')}%");
            })
            ->simplePaginate(30);

        return MediaResource::collection($records);
    }
}
