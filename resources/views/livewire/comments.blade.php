<div>
    <livewire:comment-create :post="$post"/>

    @foreach($comments as $index => $comment)

        <livewire:comment-item :comment="$comment" wire:key="comment-{{$comment->id}}-{{$comment->comments->count()}}"/>
    @endforeach
</div>

