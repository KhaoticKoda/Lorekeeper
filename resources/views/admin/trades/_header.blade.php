<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ set_active('admin/masterlist/trades/incoming*') }}" href="{{ url('admin/masterlist/trades/incoming') }}">Incoming Trades @if ($tradeCount)
                <span class="badge badge-primary">{{ $tradeCount }}</span>
            @endif
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ set_active('admin/masterlist/trades/completed*') }}" href="{{ url('admin/masterlist/trades/completed') }}">Completed Trades</a>
    </li>
</ul>
