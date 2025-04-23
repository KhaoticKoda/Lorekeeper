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
                    @include('world._item_entry', ['imageUrl' => $item->imageUrl, 'name' => $item->displayName, 'description' => $item->parsed_description, 'idUrl' => $item->idUrl, 'shops' => $shops, 'is_page' => true])
                </div>
            </div>
        </div>
        <div class="col-sm">
        </div>
    </div>
@endsection
