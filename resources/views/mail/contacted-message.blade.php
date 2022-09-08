@component('mail::message')
# Hi, there

Someone contacted you with this message:

"{{ $message }}"

Maybe, you want to get in touch using this shared email: {{ $email }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
