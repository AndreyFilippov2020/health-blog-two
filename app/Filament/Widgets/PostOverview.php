<?php

namespace App\Filament\Widgets;

use App\Models\PostView;
use App\Models\UpvoteDownvote;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PostOverview extends Widget
{

    protected int | string | array $columnSpan = 3;

    public ?Model $record = null;

    protected function getViewData(): array
    {
        // Проверяем, что $record не равен null
        if ($this->record === null) {
            return [
                'viewCount' => 0,
                'upvotes' => 0,
                'downvotes' => 0,
            ];
        }

        return [
            'viewCount' => PostView::where('post_id', '=', $this->record->id)->count(),
            'upvotes' => UpvoteDownvote::where('post_id', '=', $this->record->id)->where('is_upvote', '=', 1)->count(),
            'downvotes' => UpvoteDownvote::where('post_id', '=', $this->record->id)->where('is_upvote', '=', 0)->count(),
        ];
    }

    protected static string $view = 'filament.widgets.post-overview';
}
