@extends(".src/:assets/app")

@yield:main;

<div class="md:grid grid-rows-1 grid-flow-col gap-2 md:max-w-4xl">
        <div class="bg-gray-900 md:bg-transparent md:border border-sunglow p-5 rounded-t md:rounded-tr-none md:rounded-l md:flex items-center">
            <div class="m-2 mr-5 text-sweetred">
                <span class="text-5xl">
                    @svglogo
                </span>
            </div>
            <div>
                <h1 class="text-3xl text-sweetred">{{ _env('NAME') }}</h1>
                <p>{{ $description }}</p>
            </div>
        </div>
        <div class="bg-sunglow p-5 rounded-b md:rounded-b-none md:rounded-r">
            <h2 class="text-2xl">Documentation</h2>
            <p class="mb-3">It is worth going by documentation to get to know all the features of this framework</p>
            <a target="_blank"
            class="transition duration-150 text-white bg-sweetred font-medium rounded-md text-sm px-5 py-2.5 mr-2 mb-2 hover:opacity-90 focus:opacity-80" 
            href="https://flamephp.mrtn.vip"
            >Docs <svg class="feather feather-external-link" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"></path></svg></a>
            <a target="_blank"
            class="transition duration-150 text-white bg-sweetred font-medium rounded-md text-sm px-5 py-2.5 mr-2 mb-2 hover:opacity-90 focus:opacity-80" 
            href="https://github.com/flamephpdev/flamecore"
            >Github <svg class="feather feather-external-link" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"></path></svg></a>
        </div>
</div>
@dev
<div class="md:grid grid-rows-2 grid-flow-col gap-2 md:max-w-4xl">
        <div>
            Render Time: @getrtime()s
        </div>
        <div>
            Version: {{ VERSION }}
        </div>
        <div>
            Memory used: @formatBytes(memusage())
        </div>
        <div>
            Turn off <b>APP_DEV</b> in the env to get better resutls
        </div>
</div>
@enddev

{{-- 
    This is a development tool for Flame Core,
    Use it anywhere, it could help a lot ;)
}}

@endyield:main;