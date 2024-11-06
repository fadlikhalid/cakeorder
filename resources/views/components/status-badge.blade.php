@props(['status'])

<span class="badge rounded-pill {{ 
    $status == 'Delivered' ? 'bg-success' : 
    ($status == 'Prepared' ? 'bg-info' : 'bg-warning')
}}">
    {{ $status }}
</span> 