@component('mail::message')
# New Project 

New project has been successfully added to the website.

@component('mail::button', ['url' => 'sjonchhe.com.np'])
View Project on website
@endcomponent


@component('mail::table')
## Project details 						
|-------------------------------------------|
|Project Title 	| {{$content['title']}} 	|
|Client			|{{$content['client']}} 	|
|Contribution 	|{{$content['contribution']}}|
|Status			|{{$content['status']}} 	|


@endcomponent

---

### Description about project:
{{$content['description']}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
