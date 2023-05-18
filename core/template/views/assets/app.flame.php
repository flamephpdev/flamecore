<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?: _env('NAME','Flame Core') }}</title>
    @stylesheet('css/demo.css')
    <style>
        #@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght#@300&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
        }
        svg {
            display: inline-block;
            font-size: inherit;
            width: 1em;
            height: 1em;
            margin-top: -.3em;
        }
        .blurred {
            background-color: rgba(31,41,55,.435);
            transition: background-color .15s ease 0s,transform .15s ease 0s,-webkit-backdrop-filter .15s ease 0s;
            -webkit-backdrop-filter: blur(20px);
            backdrop-filter: blur(20px);
        }
    </style>
    @section:header;
</head>
<body class="bg-gray-800 text-white">
    @view('.src/:assets/nav',[ 'links' => $links ])

    <div class="flex h-screen overflow-hidden">
        <div class="m-auto z-10 w-full sm:w-auto">
            <div class="p-3">
                @section:main;
            </div>
        </div>
    </div>

    @dev
    @page_dev
    @enddev
</body>
</html>