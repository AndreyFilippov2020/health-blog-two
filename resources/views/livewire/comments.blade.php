<div>
    <livewire:comment-create :post="$post"/>

    @foreach($comments as $index => $comment)
        {{ $comment->id }} {{$index}} {{$comment->comments[0]->id}}
        <livewire:comment-item :comment="$comment" wire:key="comment-{{$comment->id}}--{{$index}}-{{$comment->comments->count()}}"/>
    @endforeach
</div>

