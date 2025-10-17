@component('mail::message')
# Task {{ ucfirst($action) }}

Your task **{{ $task->title }}** has been {{ $action }}.

**Description:**
{{ $task->description }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
