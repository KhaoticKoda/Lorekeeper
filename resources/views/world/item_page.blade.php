@extends('world.layout')

@section('world-title')
    {{ $item->name }}
@endsection

@section('meta-img')
    {{ $imageUrl }}
@endsection

@section('meta-desc')
    @if (isset($item->category) && $item->category)
        <p><strong>Category:</strong> {{ $item->category->name }}</p>
    @endif
    @if (isset($item->rarity) && $item->rarity)
        :: <p><strong>Rarity:</strong> {{ $item->rarity?->name ?? 'None' }}</p>
    @endif
    :: {!! substr(str_replace('"', '&#39;', $item->description), 0, 69) !!}
    @if (isset($item->uses) && $item->uses)
        :: <p><strong>Uses:</strong> {!! $item->uses !!}</p>
    @endif
@endsection

@section('content')
    {!! breadcrumbs(['World' => 'world', 'Items' => 'world/items', $item->name => $item->idUrl]) !!}

    <div class="row">
        <div class="col-sm">
        </div>
        <div class="col-lg-6 col-lg-10">
            <div class="card mb-3">
                <div class="card-body">
                    <?php
                    $shops = App\Models\Shop\Shop::where(function ($shops) {
                        if (Auth::check() && Auth::user()->isStaff) {
                            return $shops;
                        }
                        return $shops->where('is_staff', 0);
                    })
                        ->whereIn('id', App\Models\Shop\ShopStock::where('item_id', $item->id)->pluck('shop_id')->toArray())
                        ->orderBy('sort', 'DESC')
                        ->get();
                    ?>
                    
                    @if (config('lorekeeper.extensions.unmerge_item_page_and_entry'))
                        <div class="row world-entry">
                            @if ($imageUrl)
                                <div class="col-md-3 world-entry-image"><a href="{{ $imageUrl }}" data-lightbox="entry" data-title="{{ $name }}"><img src="{{ $imageUrl }}" class="world-entry-image" alt="{{ $name }}" /></a></div>
                            @endif
                            <div class="{{ $imageUrl ? 'col-md-9' : 'col-12' }}">
                                <x-admin-edit title="Item" :object="$item" />
                                <h1>
                                    @if (!$item->is_released)
                                        <i class="fas fa-eye-slash mr-1"></i>
                                    @endif
                                    <a href="{{ $item->idUrl }}">
                                        {!! $name !!}
                                    </a>
                                </h1>
                                <div class="row">
                                    @if (isset($item->category) && $item->category)
                                        <div class="col-md">
                                            <p>
                                                <strong>Category:</strong>
                                                @if (!$item->category->is_visible)
                                                    <i class="fas fa-eye-slash mx-1 text-danger"></i>
                                                @endif
                                                <a href="{!! $item->category->url !!}">
                                                    {!! $item->category->name !!}
                                                </a>
                                            </p>
                                        </div>
                                    @endif
                                    @if (config('lorekeeper.extensions.item_entry_expansion.extra_fields'))
                                        @if (isset($item->rarity) && $item->rarity)
                                            <div class="col-md">
                                                <p><strong>Rarity:</strong> {!! $item->rarity->displayName !!}</p>
                                            </div>
                                        @endif
                                        @if (isset($item->itemArtist) && $item->itemArtist)
                                            <div class="col-md">
                                                <p><strong>Artist:</strong> {!! $item->itemArtist !!}</p>
                                            </div>
                                        @endif
                                    @endif
                                    @if (isset($item->data['resell']) && $item->data['resell'] && App\Models\Currency\Currency::where('id', $item->resell->flip()->pop())->first() && config('lorekeeper.extensions.item_entry_expansion.resale_function'))
                                        <div class="col-md">
                                            <p><strong>Resale Value:</strong> {!! App\Models\Currency\Currency::find($item->resell->flip()->pop())->display($item->resell->pop()) !!}</p>
                                        </div>
                                    @endif
                                    <div class="col-md-5 col-md">
                                        <div class="row">
                                            @foreach ($item->tags as $tag)
                                                @if ($tag->is_active)
                                                    <div class="col">
                                                        {!! $tag->displayTag !!}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="world-entry-text">
                                    @if (isset($item->reference) && $item->reference && config('lorekeeper.extensions.item_entry_expansion.extra_fields'))
                                        <p>
                                            <strong>Reference Link:</strong>
                                            <a href="{{ $item->reference }}">
                                                {{ $item->reference }}
                                            </a>
                                        </p>
                                    @endif
                                    {!! $description !!}
                                    @if (((isset($item->uses) && $item->uses) || (isset($item->source) && $item->source) || $item->shop_stock_count || (isset($item->data['prompts']) && $item->data['prompts'])) && config('lorekeeper.extensions.item_entry_expansion.extra_fields'))
                                        <div id="item-{{ $item->id }}">
                                            @if (isset($item->uses) && $item->uses)
                                                <p>
                                                    <strong>Uses:</strong> {{ $item->uses }}
                                                </p>
                                            @endif
                                            @if ((isset($item->source) && $item->source) || $item->shop_stock_count || (isset($item->data['prompts']) && $item->data['prompts']))
                                                <h5>Availability</h5>
                                                <div class="row">
                                                    @if (isset($item->source) && $item->source)
                                                        <div class="col">
                                                            <p>
                                                                <strong>Source:</strong>
                                                            </p>
                                                            <p>
                                                                {!! $item->source !!}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($item->shop_stock_count)
                                                        <div class="col">
                                                            <p>
                                                                <strong>Purchaseable At:</strong>
                                                            </p>
                                                            <div class="row">
                                                                @foreach ($item->shops(Auth::user() ?? null) as $shop)
                                                                    <div class="col">
                                                                        <a href="{{ $shop->url }}">
                                                                            {{ $shop->name }}
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (isset($item->data['prompts']) && $item->data['prompts'])
                                                        <div class="col">
                                                            <p>
                                                                <strong>Drops From:</strong>
                                                            </p>
                                                            <div class="row">
                                                                @foreach ($item->prompts as $prompt)
                                                                    <div class="col">
                                                                        <a href="{{ $prompt->url }}">
                                                                            {{ $prompt->name }}
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        @include('world._item_entry', ['imageUrl' => $item->imageUrl, 'name' => $item->displayName, 'description' => $item->parsed_description, 'idUrl' => $item->idUrl, 'shops' => $shops, 'isPage' => true])
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm">
        </div>
    </div>
@endsection
