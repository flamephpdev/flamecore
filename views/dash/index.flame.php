@extends:.src/:assets/app;

@yield:main;

<div class="bg-gray-900 p-5 rounded">
    <h1 class="text-3xl text-sweetred">Dashboard</h1>
                                    {{-- Simple server side comment,
                                        Get the username by the user instance
                                        returned by the user() function
                                    }}
    <p>Welcome! You're logged in as <b>{{ ucfirst(user()->username) }}</b>.</p>
</div>

#flame-engine.ignore:next-line
@Check the dash view file code to disable the<br>{{ parser }} for the next line

@endyield:main;