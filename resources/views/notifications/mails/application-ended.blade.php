<x-mail::message>
# Hello

your interview with {{$application->name}} has ended.
<br>
please select the status you want to set the application to:

@foreach ($possibleStatuses as $status )
<a href="{{URL::signedRoute(
            'store-manager.application-status.update',[
                'application' => $application->id,
                'status' => $status->id
            ]
        )}}">
    {{$status->name}}
</a>
<br>
@endforeach

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
