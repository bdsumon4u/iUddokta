<div class="p-2" style="max-height: 500px;">
    @foreach((new App\Services\EarningService(auth('reseller')->user()))->periods ?? [] as $period)
    <a href="{{ route('earnings', ['reseller_id' => auth('reseller')->user(), 'period' => $period]) }}" class="btn btn-light btn-block text-left">{{ $period }}</a>
    @endforeach
</div>