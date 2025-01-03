@extends('home.trades.listings.layout')

@section('trade-title') Trades @endsection

@section('trade-content')
    {!! breadcrumbs(['Trades' => 'trades/open', 'Listings' => 'trades/listings', 'New Listing' => 'trades/listings/create']) !!}

    <h1>
        New Trade Listing
    </h1>

    <p>
        Create a new trade listing.
        <strong>Some notes:</strong>
        <ul>
            <li>The title should be informative and not include anything that breaks {{ config('lorekeeper.settings.site_name') }}'s rules.</li>
            <li>You can't modify the listing after its creation, so make sure everything is correct!</li>
            <li>Note that you may only add up to <strong>{{ config('lorekeeper.settings.trade_asset_limit') }}</strong> things to each side (seeking / offering) of a listing—if necessary, please create a new listing to add more.</li>
            <li><strong>Note that this does not interact automatically with the trade system;</strong> while trade listings should <strong>not</strong> be tentative, including an item or character you own within a listing will not inherently do anything with the item/character(s), and you will need to add them to trade(s) on your own.</li>
            <ul><li>Traded items / characters are not automatically removed from a listing.</li></ul>
            <li>Listings expire after {{ $listingDuration }} days. You will also be able to manually mark a listing as expired before that point.</li>
        </ul>
    </p>

    {!! Form::open(['url' => 'trades/listings/create']) !!}
        <div class="card mb-3">
            <div class="card-header h2">
                Listing Details
            </div>
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('title', 'Listing Title (Optional)') !!}
                    {!! add_help('This is what the public will see as the trade listing. <br>Try to be informative.') !!}
                    {!! Form::text('title', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('comments', 'Comments (Optional)') !!} {!! add_help('This comment will be displayed on the trade index. You can write a helpful note here, for example to note down the purpose of the trade.') !!}
                    {!! Form::textarea('comments', null, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('contact', 'Preferred Method(s) of Contact') !!}
                    {!! add_help('Enter in your preferred method(s) of contact. This field cannot be left blank.') !!}
                    {!! Form::text('contact', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header h2">
                Seeking
                <a class="small inventory-collapse-toggle collapse-toggle" href="#userSeeking" data-toggle="collapse">Show</a>
            </div>
            <div class="mb-3 collapse card-body" id="userSeeking">
                <p>Select the items, currencies, and / or other goods or services you're seeking.</p>
                @include('widgets._loot_select', [
                    'loots' => [],
                    'showLootTables' => false,
                    'showRaffles' => false,
                    'type' => 'Seeking',
                ])
                <h3>Other</h3>
                <div class="form-group">
                    {!! Form::label('seeking_etc', 'Other Goods or Services') !!}
                    {!! add_help('Enter in any goods/services you are seeking that are not handled by the site-- for example, art. This should be brief!') !!}
                    {!! Form::text('seeking_etc', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header h2">
                Offering
                <a class="small inventory-collapse-toggle collapse-toggle" href="#userOffering" data-toggle="collapse">Show</a>
            </div>
            <div class="mb-3 collapse card-body" id="userOffering">
                <p>Select the items, characters, currencies, and/or other goods or services you're offering.</p>
                @include('widgets._inventory_select', ['user' => Auth::user(), 'inventory' => $inventory, 'categories' => $categories, 'selected' => [], 'page' => $page])
                @include('widgets._my_character_select', ['readOnly' => true, 'categories' => $characterCategories])
                @if(isset($currencies) && $currencies)
                    <h3>Currencies</h3>
                    <div class="form-group">
                        {!! Form::select('offer_currency_ids[]', $currencies, 0, ['class' => 'form-control selectize', 'multiple']) !!}
                    </div>
                @endif
                <h3>Other</h3>
                <div class="form-group">
                    {!! Form::label('offering_etc', 'Other Goods or Services') !!}
                    {!! add_help('Enter in any goods/services you are offerering that are not handled by the site-- for example, art. This should be brief!') !!}
                    {!! Form::text('offering_etc', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>

        <div class="text-right">
            {!! Form::submit('Create Listing', ['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}

    @include('widgets._loot_select_row', [
        'showLootTables' => false,
        'showRaffles' => false,
        'type' => 'Seeking',
    ])

@endsection
@section('scripts')
    @include('js._loot_js', [
        'showLootTables' => false,
        'showRaffles' => false,
        'useCustomSelectize' => true,
    ])
    @include('widgets._inventory_select_js', ['readOnly' => true])
    @include('widgets._my_character_select_js', ['readOnly' => true])
    @parent
    <script>
        $(document).ready(function() {
            $('.selectize').selectize();
            $('.default.item-select').selectize({
                render: {
                    option: customItemSelectizeRender,
                    item: customItemSelectizeRender
                }
            });

            $('#add-item').on('click', function(e) {
                e.preventDefault();
                addItemRow();
            });
            $('.remove-item').on('click', function(e) {
                e.preventDefault();
                removeItemRow($(this));
            });

            function addItemRow() {
                var $rows = $("#itemList > div")
                if($rows.length === 1) {
                    $rows.find('.remove-item').removeClass('disabled')
                }
                var $clone = $('.item-row').clone();
                $('#itemList').append($clone);
                $clone.removeClass('hide item-row');
                $clone.addClass('d-flex');
                $clone.find('.remove-item').on('click', function(e) {
                    e.preventDefault();
                    removeItemRow($(this));
                })
                $clone.find('.item-select').selectize({
                    render: {
                        option: customItemSelectizeRender,
                        item: customItemSelectizeRender
                    }
                });
            }
            function removeItemRow($trigger) {
                $trigger.parent().remove();
                var $rows = $("#itemList > div")
                if($rows.length === 1) {
                    $rows.find('.remove-item').addClass('disabled')
                }
            }

            function customItemSelectizeRender(item, escape) {
                console.log(item);
                item = JSON.parse(item.text);
                option_render = '<div class="option">';
                if (item['image_url']) {
                    option_render += '<div class="d-inline mr-1"><img class="small-icon" alt="' + escape(item['name']) + '" src="' + escape(item['image_url']) + '"></div>';
                }
                option_render += '<span>' + escape(item['name']) + '</span></div>';
                return option_render;
            }
        });
    </script>
@endsection
