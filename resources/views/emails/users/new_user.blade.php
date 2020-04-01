@component('mail::message')
# Novo Usuário Registrado

### Seu site possui um novo usuário registrado!

## Informações

**ID:** {{$id}}
**Nome:** {{$name}}
**Email:** {{$email}}

@component('mail::button', ['url' => ''])
Botão de Teste
@endcomponent

Obrigado,<br>
{{ config('app.name') }}

> Este e-mail foi enviado automaticamente, favor não responder.
@endcomponent
