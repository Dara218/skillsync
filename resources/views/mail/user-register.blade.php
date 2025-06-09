<x-mail::message>
# Registration Successful.

Thank you for registering with Skill Sync! You can now verify your email by clicking the email below.

<x-mail::button :url="route('user.dashboard')">
Verify Email.
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
