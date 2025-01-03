@php
    // This file represents a common source and definition for assets used in loot_select
    // While it is not per se as tidy as defining these in the controller(s),
    // doing so this way enables better compatibility across disparate extensions
    if (isset($useCustomSelectize) && $useCustomSelectize) {
        $characterCurrencies = \App\Models\Currency\Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->get()->mapWithKeys(function ($currency) {
            return [
                $currency->id => json_encode([
                    'name' => $currency->name,
                    'image_url' => $currency->image_url,
                ]),
            ];
        });
        $items = \App\Models\Item\Item::orderBy('name')->get()->mapWithKeys(function ($item) {
            return [
                $item->id => json_encode([
                    'name' => $item->name,
                    'image_url' => $item->image_url,
                ]),
            ];
        });
        $currencies = \App\Models\Currency\Currency::where('is_user_owned', 1)->orderBy('name')->get()->mapWithKeys(function ($currency) {
            return [
                $currency->id => json_encode([
                    'name' => $currency->name,
                    'image_url' => $currency->image_url,
                ]),
            ];
        });
        if ($showLootTables) {
            $tables = \App\Models\Loot\LootTable::orderBy('name')->get()->mapWithKeys(function ($table) {
                return [
                    $table->id => json_encode([
                        'name' => $table->name,
                    ]),
                ];
            });
        }
        if ($showRaffles) {
            $raffles = \App\Models\Raffle\Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->get()->mapWithKeys(function ($raffle) {
                return [
                    $raffle->id => json_encode([
                        'name' => $raffle->name,
                    ]),
                ];
            });
        }
    } else {
        $characterCurrencies = \App\Models\Currency\Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->pluck('name', 'id');
        $items = \App\Models\Item\Item::orderBy('name')->pluck('name', 'id');
        $currencies = \App\Models\Currency\Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id');
        if ($showLootTables) {
            $tables = \App\Models\Loot\LootTable::orderBy('name')->pluck('name', 'id');
        }
        if ($showRaffles) {
            $raffles = \App\Models\Raffle\Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id');
        }
    }
@endphp
