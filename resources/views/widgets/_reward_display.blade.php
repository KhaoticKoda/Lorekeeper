@php
    $rewards = objectRewards($object, $reward_key, $recipient);
@endphp

<hr class="my-4 w-75" />

<h4>{{ ucfirst($type) }} Rewards ({!! $recipient == 'User' ? 'User <i class="fas fa-user"></i>' : 'Character <i class="fas fa-paw"></i>' !!} )</h4>

@if (isset($info))
    <div class="alert alert-info">{!! $info !!}</div>
@endif
@if ($rewards->count())
    <div class="mb-4 logs-table">
        <div class="logs-table-header">
            <div class="row">
                <div class="col-5 col-md-6">
                    <div class="logs-table-cell">Reward</div>
                </div>
                <div class="col-5 col-md-5">
                    <div class="logs-table-cell">Amount</div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            @foreach ($rewards as $reward)
                <div class="logs-table-row">
                    <div class="row flex-wrap">
                        <div class="col-5 col-md-6">
                            <div class="logs-table-cell">
                                {!! $reward->reward->displayName !!}
                            </div>
                        </div>
                        <div class="col-4 col-md-5">
                            <div class="logs-table-cell">{{ $reward->quantity }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <p>No rewards.</p>
@endif
@if (isset($showHr) && $showHr)
    <hr class=" w-75" />
@endif
