<x-mail::message>
# Email Update Request

Hi {{ $name }},

There was an attempt requesting to change your email from {{ $old_email }}

To confirm the update to this email, click the button below:

<x-mail::button :url="$url">
Confirm Email Update
</x-mail::button>

If you didn’t request this process, feel free to ignore this message.

Sincerely,  
{{ config('app.name') }}
</x-mail::message>
