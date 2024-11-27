<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Events\PostCreated;
use App\Filament\Resources\PostResource;
use App\Jobs\NewsLetterJob;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

//    protected function mutateFormDataBeforeCreate(array $data): array
//    {
//        $data['user_id'] = auth()->id();
//
//        return $data;
//    }

    protected function handleRecordCreation(array $data): Model
    {
        $data['user_id'] = auth()->id();

        $post = static::getModel()::create($data);

        if ($post->active === true ) {
//            if (Carbon::parse($post->published_at)->greaterThan(Carbon::now())) {
//                $delay = Carbon::now()->diffInSeconds(Carbon::parse($post->published_at));
//                NewsLetterJob::dispatch($post)->delay($delay);
//            } else {
//                NewsLetterJob::dispatch($post);
//            }
            event(new PostCreated($post));
        }

        return $post;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
