<x-mail::message>
# Registration Successful

Hi {{ $name }},

Thank you for joining Skill Sync!

To verify your account, please enter the following code:

**{{ $code }}**

This code is confidential—please do not share it with anyone.

If you didn’t create an account, feel free to ignore this message.

Sincerely,  
{{ config('app.name') }}
</x-mail::message>
