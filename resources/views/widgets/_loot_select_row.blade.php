@php
    // This file represents a common source and definition for assets used in loot_select
    // While it is not per se as tidy as defining these in the controller(s),
    // doing so this way enables better compatibility across disparate extensions
    $characterCurrencies = \App\Models\Currency\Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->pluck('name', 'id');
    $items = \App\Models\Item\Item::orderBy('name')->pluck('name', 'id');
    $currencies = \App\Models\Currency\Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id');

    // Reward types, should reduce friction of merge conflicts
    $rewardTypes =
        [
            'Item' => 'Item',
            'Currency' => 'Currency',
        ] +
        ($showLootTables ? ['LootTable' => 'Loot Table'] : []) +
        ($showRaffles ? ['Raffle' => 'Raffle Ticket'] : []);

    if ($showLootTables) {
        $tables = \App\Models\Loot\LootTable::orderBy('name')->pluck('name', 'id');
    }
    if ($showRaffles) {
        $raffles = \App\Models\Raffle\Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id');
    }
    if (!isset($prefix)) {
        $prefix = '';
    }
    if (!isset($showRecipient)) {
        $showRecipient = false;
    }
@endphp

<div id="{{ $prefix }}lootRowData" class="hide">
    <table class="table table-sm">
        <tbody id="{{ $prefix }}lootRow">
            <tr class="loot-row">
                @if ($showRecipient)
                    <td>
                        {!! Form::select($prefix . 'rewardable_recipient[]', ['Character' => 'Character', 'User' => 'User'], 'User', [
                            'class' => 'form-control',
                            'placeholder' => 'Select Recipient Type',
                        ]) !!}
                    </td>
                @endif
                <td>
                    {!! Form::select($prefix . 'rewardable_type[]', $rewardTypes, null, [
                        'class' => 'form-control reward-type',
                        'placeholder' => 'Select Reward Type',
                    ]) !!}
                </td>
                <td class="loot-row-select"></td>
                <td>{!! Form::text($prefix . 'quantity[]', 1, ['class' => 'form-control']) !!}</td>
                @if (isset($extra_fields))
                    @foreach ($extra_fields as $field => $data)
                        <td>
                            @php
                                $field_name = $prefix . $field . '[]';
                                $value = $data['default'] ?? null;
                                $attributes = $data['attributes'] ?? [];
                            @endphp
                            {!! Form::{$data['type']}($field_name, $value, array_merge(['class' => 'form-control ' . ($data['class'] ?? ''), 'placeholder' => $data['label']], $attributes)) !!}
                        </td>
                        @if ($data['label'] == 'Weight')
                            <td class="loot-row-chance"></td>
                        @endif
                    @endforeach
                @endif
                <td class="text-right"><a href="#" class="btn btn-danger remove-loot-button">Remove</a></td>
            </tr>
        </tbody>
    </table>
    {!! Form::select($prefix . 'rewardable_id[]', $items, null, ['class' => 'form-control item-select', 'placeholder' => 'Select Item']) !!}
    {!! Form::select($prefix . 'rewardable_id[]', $currencies, null, ['class' => 'form-control currency-select', 'placeholder' => 'Select Currency']) !!}
    @if ($showLootTables)
        {!! Form::select($prefix . 'rewardable_id[]', $tables, null, ['class' => 'form-control table-select', 'placeholder' => 'Select Loot Table']) !!}
    @endif
    @if ($showRaffles)
        {!! Form::select($prefix . 'rewardable_id[]', $raffles, null, ['class' => 'form-control raffle-select', 'placeholder' => 'Select Raffle']) !!}
    @endif
</div>
