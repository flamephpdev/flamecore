@extends:.src/:assets/app;

@yield:main;

<div class="bg-gray-900 p-5 rounded-lg">
     <h1 class="text-3xl">Auth</h1>
     <hr class="border-2 border-gray-800 rounded-lg my-3">
     {{
          view('.src/:auth/form',$form)
     }}
</div>


@endyield:main;