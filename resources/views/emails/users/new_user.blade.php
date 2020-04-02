@component('mail::message')
{{--# Novo Usuário Registrado--}}

# Seu site possui um novo usuário registrado!

## Informações

**ID:** {{$id}}<br>
**Nome:** {{$name}}<br>
**Email:** {{$email}}

@component('mail::button', ['url' => ''])
Botão de Teste
@endcomponent

Este e-mail foi enviado automaticamente, favor não responder.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
