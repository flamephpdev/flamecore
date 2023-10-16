<nav class="border-gray-200 fixed top-0 w-full blurred z-50">
     <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
          <a href="{{url('/')}}" class="flex items-center">
               <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">
                    @svglogo Flame Core
               </span>
          </a>
          @if(isset($links) && is_array($links)):
               <button type="button" class="inline-flex items-center p-2 ml-3 text-sm rounded-lg md:hidden focus:outline-none text-gray-400 hover:bg-gray-700" onclick="const menu = document.getElementById('menu');menu.classList.contains('hidden') ? menu.classList.remove('hidden') : menu.classList.add('hidden')">
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
               </button>
               <div class="hidden w-full md:block md:w-auto" id="menu">
                    <ul class="font-medium flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0">
                         @foreach($links as $link):
                              @if(!in_array('no-display',$link)):
                                   <li>
                                        <a 
                                        href="{{ $link['href'] }}" 
                                        class="{{ in_array('active',$link) ? 'block py-2 pl-3 pr-4 bg-sweetred rounded md:bg-transparent md:p-0 text-white md:text-sweetred my-1' : 'block py-2 pl-3 pr-4 rounded md:border-0 md:p-0 text-white md:hover:text-sweetred hover:bg-sweetred hover:text-white md:hover:bg-transparent my-1' }}"
                                        >{{ $link['title'] }}</a>
                                   </li>
                              @endif
                         @endforeach
                         @if(_env('APP_DEV') && false /* Sorry this is under a refactor... */):
                              <li>
                                   <a href="{{ route('pkg.fwm.index') }}" class="block py-2 pl-3 pr-4 rounded md:border-0 md:p-0 text-white md:hover:text-sweetred hover:bg-sweetred hover:text-white md:hover:bg-transparent my-1">FWM Dashboard</a>
                              </li>
                         @endif
                    </ul>
               </div>
          @endif
     </div>
</nav>