@component('mail::message')
# {{ $data['subject'] }}

{{ $data['message'] }}

From,<br>
{!! nl2br($data['email']) !!}
@endcomponent