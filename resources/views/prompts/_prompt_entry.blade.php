<div class="row world-entry">
    @if($prompt->has_image)
        <div class="col-md-3 world-entry-image"><a href="{{ $prompt->imageUrl }}" data-lightbox="entry" data-title="{{ $prompt->name }}"><img src="{{ $prompt->imageUrl }}" class="world-entry-image" alt="{{ $prompt->name }}" /></a></div>
    @endif
    <div class="{{ $prompt->has_image ? 'col-md-9' : 'col-12' }}">
        <div class="mb-3">
            <h3 class="mb-0">{!! $prompt->name !!}</h3>
            @if($prompt->prompt_category_id)
                <div><strong>Category: </strong>{!! $prompt->category->displayName !!}</div>
            @endif
            @if($prompt->start_at && $prompt->start_at->isFuture())
                <div><strong>Starts: </strong>{!! format_date($prompt->start_at) !!} ({{ $prompt->start_at->diffForHumans() }})</div>
            @endif
            @if($prompt->end_at)
                <div><strong>Ends: </strong>{!! format_date($prompt->end_at) !!} ({{ $prompt->end_at->diffForHumans() }})</div>
            @endif
        </div>
        <div class="world-entry-text">
            <p>{{ $prompt->summary }}</p>
            <div class="text-right"><a data-toggle="collapse" href="#prompt-{{ $prompt->id }}" class="text-primary"><strong>Show details...</strong></a></div>
            <div class="collapse" id="prompt-{{ $prompt->id }}">
                <h4>Details</h4>
                @if($prompt->parsed_description)
                    {!! $prompt->parsed_description !!}
                @else
                    <p>No further details.</p>
                @endif
                @if($prompt->hide_submissions == 1 && isset($prompt->end_at) && $prompt->end_at > Carbon\Carbon::now())
                    <p class="text-info">Submissions to this prompt are hidden until this prompt ends.</p>
                @elseif($prompt->hide_submissions == 2)
                    <p class="text-info">Submissions to this prompt are hidden.</p>
                @endif
            </div>
            @include('widgets._reward_display', [
                'object' => $prompt,
                'type' => 'prompt',
                'reward_key' => 'objectRewards',
                'recipient' => 'User',
            ])
            @include('widgets._reward_display', [
                'object' => $prompt,
                'type' => 'prompt',
                'reward_key' => 'objectCharacterRewards',
                'recipient' => 'Character',
                'info' => 'Only focus characters will recieve these rewards.',
            ])
        </div>
        <div class="text-right">
            @if($prompt->end_at && $prompt->end_at->isPast())
                <span class="text-secondary">This prompt has ended.</span>
            @elseif($prompt->start_at && $prompt->start_at->isFuture())
                <span class="text-secondary">This prompt is not open for submissions yet.</span>
            @else
                <a href="{{ url('submissions/new?prompt_id=' . $prompt->id) }}" class="btn btn-primary">Submit Prompt</a>
            @endunless
        </div>
    </div>
</div>
