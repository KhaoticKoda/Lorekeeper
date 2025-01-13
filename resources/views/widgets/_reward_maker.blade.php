@php
    //idk what to name this variable, it's in case you want to add an addition to the title ($keytitle user rewards) given that now we have reward keys for multiple attachments to the same model

//so you could add some other textual identifier for another purpose so you won't confuse yourself with multiple identical fields.
    if (!isset($keytitle)) {
        $keytitle = '';
    }
@endphp

@if (!$object->id)
    <hr style="margin-top: 3em;">
    <div class="card mb-3">
        <div class="card-header h2">
            {{ $keytitle }} {{ ucfirst($type) }} Rewards ({!! $recipient == 'User' ? 'User <i class="fas fa-user"></i>' : 'Character <i class="fas fa-paw"></i>' !!} )
        </div>
        <div class="card-body" style="clear:both;">
            <p>You can create <strong>{{ $keytitle }} {{ $recipient }} rewards</strong> once the {{ $type }} has been made.</p>
            </p>
        </div>
    </div>
@else
    {!! Form::open(['url' => 'admin/data/reward-maker/edit/' . base64_encode(urlencode(get_class($object))) . '/' . $object->id]) !!}

    @php
        // This file represents a common source and definition for assets used in loot_select
        // While it is not per se as tidy as defining these in the controller(s),
        // doing so this way enables better compatibility across disparate extensions

        //isUser variable for character specifics
        $isUser = $recipient == 'User';

        if ($isUser) {
            $items = \App\Models\Item\Item::orderBy('name')->pluck('name', 'id');
            $currencies = \App\Models\Currency\Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id');
            $raffles = \App\Models\Raffle\Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id');
        } else {
            $items = \App\Models\Item\Item::whereIn('item_category_id', \App\Models\Item\ItemCategory::where('is_character_owned', 1)->pluck('id')->toArray())
                ->orderBy('name')
                ->pluck('name', 'id');
            $currencies = \App\Models\Currency\Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->pluck('name', 'id');
        }
        $tables = \App\Models\Loot\LootTable::orderBy('name')->pluck('name', 'id');

        //get the rewards
        $rewards = objectRewards($object, $reward_key, $recipient);

        //get the types
        $reward_types = ['Item' => 'Item', 'Currency' => 'Currency', 'LootTable' => 'Loot Table'] + ($isUser ? ['Raffle' => 'Raffle'] : []);
    @endphp
    {!! Form::hidden('recipient_type', $recipient) !!}
    {!! Form::hidden('reward_key', $reward_key) !!}
    <hr style="margin-top: 3em;">

    <div class="card mb-3">
        <div class="card-header">
            <a href="#" class="btn btn-outline-info float-right" id="addReward{{ $reward_key }}{{ $recipient }}">Add Reward</a>
            <div data-toggle="collapse" href="#collapserewards{{ $reward_key }}{{ $recipient }}">
                <h2>{{ $keytitle }} {{ ucfirst($type) }} Rewards ({!! $isUser ? 'User <i class="fas fa-user"></i>' : 'Character <i class="fas fa-paw"></i>' !!} )</h2>
                <div class="text-muted">Display is collapsed to shorten the page, click to expand</div>
            </div>
        </div>
        <div class="card-body collapse collapsed" style="clear:both;" id="collapserewards{{ $reward_key }}{{ $recipient }}">
            <p>You can add {{ $keytitle }} {!! $isUser ? 'user' : 'character' !!} rewards to this {{ $type }} here.</p>
            @if (isset($info))
                <div class="alert alert-info">{!! $info !!}</div>
            @endif
            <div class="mb-3">
                <table class="table table-sm" id="rewardTable{{ $reward_key }}{{ $recipient }}">
                    <thead>
                        <tr>
                            <th width="35%">Reward Type</th>
                            <th width="35%">Reward</th>
                            <th width="20%">Quantity</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody id="rewardTableBody{{ $reward_key }}{{ $recipient }}">
                        @if ($rewards->count())
                            @foreach ($rewards as $reward)
                                <tr class="reward-row">
                                    <td>{!! Form::select('rewardable_type[]', $reward_types, $reward->rewardType(), [
                                        'class' => 'form-control reward-type selectize',
                                        'placeholder' => 'Select Reward Type',
                                    ]) !!}</td>
                                    <td class="reward-row-select">
                                        @if ($reward->rewardType() == 'Item')
                                            {!! Form::select('rewardable_id[]', $items, $reward->rewardable_id, ['class' => 'form-control item-select selectize', 'placeholder' => 'Select Item']) !!}
                                        @elseif($reward->rewardType() == 'Currency')
                                            {!! Form::select('rewardable_id[]', $currencies, $reward->rewardable_id, ['class' => 'form-control currency-select selectize', 'placeholder' => 'Select Currency']) !!}
                                        @elseif($reward->rewardType() == 'LootTable')
                                            {!! Form::select('rewardable_id[]', $tables, $reward->rewardable_id, ['class' => 'form-control table-select selectize', 'placeholder' => 'Select Loot Table']) !!}
                                        @elseif($isUser && $reward->rewardType() == 'Raffle')
                                            {!! Form::select('rewardable_id[]', $raffles, $reward->rewardable_id, ['class' => 'form-control raffle-select selectize', 'placeholder' => 'Select Raffle']) !!}
                                        @endif
                                    </td>
                                    <td>{!! Form::text('reward_quantity[]', $reward->quantity, ['class' => 'form-control']) !!}</td>
                                    <td class="text-right"><a href="#" class="btn btn-danger remove-reward-button">Remove</a></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-right">
        {!! Form::submit('Edit ' . $keytitle . ' ' . $recipient . ' Rewards', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if (isset($showHr) && $showHr)
        <hr style="margin-bottom: 1em;">
    @endif

    <div id="rewardRowData{{ $reward_key }}{{ $recipient }}" class="hide">
        <table class="table table-sm">
            <tbody id="rewardRow{{ $reward_key }}{{ $recipient }}">
                <tr class="reward-row">
                    <td>{!! Form::select('rewardable_type[]', $reward_types, null, [
                        'class' => 'form-control reward-type selectize',
                        'placeholder' => 'Select Reward Type',
                    ]) !!}</td>
                    <td class="reward-row-select"></td>
                    <td>{!! Form::text('reward_quantity[]', 1, ['class' => 'form-control']) !!}</td>
                    <td class="text-right"><a href="#" class="btn btn-danger remove-reward-button">Remove</a></td>
                </tr>
            </tbody>
        </table>
        {!! Form::select('rewardable_id[]', $items, null, ['class' => 'form-control item-select', 'placeholder' => 'Select Item']) !!}
        {!! Form::select('rewardable_id[]', $currencies, null, ['class' => 'form-control currency-select', 'placeholder' => 'Select Currency']) !!}
        {!! Form::select('rewardable_id[]', $tables, null, ['class' => 'form-control table-select', 'placeholder' => 'Select Loot Table']) !!}
        @if ($isUser)
            {!! Form::select('rewardable_id[]', $raffles, null, ['class' => 'form-control raffle-select', 'placeholder' => 'Select Raffle']) !!}
        @endif
    </div>


    <script>
        $(document).ready(function() {
            var $rewardTable = $('#rewardTableBody{{ $reward_key }}{{ $recipient }}');
            var $rewardRow = $('#rewardRow{{ $reward_key }}{{ $recipient }}').find('.reward-row');
            var $itemSelect = $('#rewardRowData{{ $reward_key }}{{ $recipient }}').find('.item-select');
            var $currencySelect = $('#rewardRowData{{ $reward_key }}{{ $recipient }}').find('.currency-select');
            var $tableSelect = $('#rewardRowData{{ $reward_key }}{{ $recipient }}').find('.table-select');
            @if ($isUser)
                var $raffleSelect = $('#rewardRowData{{ $reward_key }}{{ $recipient }}').find('.raffle-select');
            @endif
            $('#rewardTableBody{{ $reward_key }}{{ $recipient }} .selectize').selectize();
            attachrewardTypeListener($('#rewardTableBody{{ $reward_key }}{{ $recipient }} .reward-type'));
            attachRemoveListener($('#rewardTableBody{{ $reward_key }}{{ $recipient }} .remove-reward-button'));
            $('#addReward{{ $reward_key }}{{ $recipient }}').on('click', function(e) {
                e.preventDefault();
                var $clone = $rewardRow.clone();
                $rewardTable.append($clone);
                $clone.find('.selectize').selectize();
                attachrewardTypeListener($clone.find('.reward-type'));
                attachRemoveListener($clone.find('.remove-reward-button'));
            });
            $('.reward-type').on('change', function(e) {
                var val = $(this).val();
                var $cell = $(this).parent().find('.reward-row-select');
                var $clone = null;
                if (val == 'Item') $clone = $itemSelect.clone();
                else if (val == 'Currency') $clone = $currencySelect.clone();
                else if (val == 'LootTable') $clone = $tableSelect.clone();
                @if ($isUser)
                    else if (val == 'Raffle') $clone = $raffleSelect.clone();
                @endif
                $cell.html('');
                $cell.append($clone);
            });

            function attachrewardTypeListener(node) {
                node.on('change', function(e) {
                    var val = $(this).val();
                    var $cell = $(this).parent().parent().find('.reward-row-select');
                    var $clone = null;
                    if (val == 'Item') $clone = $itemSelect.clone();
                    else if (val == 'Currency') $clone = $currencySelect.clone();
                    else if (val == 'LootTable') $clone = $tableSelect.clone();
                    @if ($isUser)
                        else if (val == 'Raffle') $clone = $raffleSelect.clone();
                    @endif
                    $cell.html('');
                    $cell.append($clone);
                    $clone.selectize();
                });
            }

            function attachRemoveListener(node) {
                node.on('click', function(e) {
                    e.preventDefault();
                    $(this).parent().parent().remove();
                });
            }
        });
    </script>
@endif
