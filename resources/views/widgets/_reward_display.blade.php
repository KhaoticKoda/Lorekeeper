<hr class="my-4 w-75" />

<h4>{{ ucfirst($type) }} Rewards ({!! $recipient == 'User' ? 'User <i class="fas fa-user"></i>' : 'Character <i class="fas fa-paw"></i>' !!} )</h4>

@if (isset($info))
    <div class="alert alert-info">{!! $info !!}</div>
@endif
@if ($object->$reward_key->count())
    <table class="table table-sm">
        <thead>
            <tr>
                <th width="70%">Reward</th>
                <th width="30%">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($object->$reward_key as $reward)
                <tr>
                    <td>{!! $reward->reward->displayName !!}</td>
                    <td>{{ $reward->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No rewards.</p>
@endif
@if (isset($showHr) && $showHr)
    <hr class=" w-75" />
@endif
