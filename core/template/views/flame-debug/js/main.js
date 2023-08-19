// #FlameCore new debugger js "FlameDebugger"

class FlameCoreDebugApplication {
     makeResizableDiv(e){const n=document.querySelector(e);var t=document.querySelectorAll(e+" .resizer");const o=20,i=window.innerHeight-100;let r=0,l=0,u=0;for(let e=0;e<t.length;e++){const d=t[e];function s(e){var t=r-(e.pageY-u);t>o&&t<i&&(n.style.height=t+"px",n.style.top=l+(e.pageY-u)+"px")}function a(){window.removeEventListener("mousemove",s)}d.addEventListener("mousedown",function(e){e.preventDefault(),r=parseFloat(getComputedStyle(n,null).getPropertyValue("height").replace("px","")),l=n.getBoundingClientRect().top,u=e.pageY,window.addEventListener("mousemove",s),window.addEventListener("mouseup",a)})}}

     createDebuggerPopupBar = (vars) => {
          const button = document.querySelector(`[${vars.attribute}="button:${vars.appId}"]`)
          const _app_selector = `[${vars.attribute}="app:${vars.appId}"]`;
          const app = document.querySelector(_app_selector)
          const tabs = document.querySelector(`${_app_selector}>[debugger_tabs]`)
          const pages = document.querySelector(`${_app_selector}>[debugger_pages]`)
          button.addEventListener('click', () => {
               app.classList.toggle('hidden')
          })
     
          const tabChange = (e) => {
               const target = e.target
               const drkey = e.target.innerText
               const drEl = document.querySelector(`[data-debugger-recognizer-key="${drkey}"]`)
               Object.keys(tabs.children).forEach(key => {
                    const child = tabs.children[key]
                    if(child.hasAttribute('debugger__tab_selected')) {
                         child.removeAttribute('debugger__tab_selected')
                         const _drEl = document.querySelector(`[data-debugger-recognizer-key="${child.innerText}"]`)
                         _drEl.classList.add('hidden')
                    }
               })
               target.setAttribute('debugger__tab_selected', true)
               drEl.classList.remove('hidden')
          }
     
          const makeTabs = (_tabs) => {
               let first = true
               const classList = "transition duration-150 cursor-pointer flex flex-col bg-gray-900 text-xl px-5 py-2 h-full hover:bg-gray-950 border-r"
               Object.keys(_tabs).forEach(key => {
                    const el = document.createElement('div')
                    classList.split(' ').forEach(c => {
                         el.classList.add(c)
                    })
                    if(first) {
                         el.setAttribute('debugger__tab_selected', true)
                         el.classList.add('border-l')
                         first = false
                    }
                    el.innerText = key.replace('_', ' ')
                    el.addEventListener('click', tabChange)
                    tabs.append(el)
               })
               const el = document.createElement('div')
               classList.split(' ').forEach(c => {
                    if(!c.startsWith('border')) el.classList.add(c)
               })
               el.innerHTML = '&times;'
               el.addEventListener('click', () => {
                    app.classList.toggle('hidden')
               })
               tabs.append(el)
          }
          
          let _first = true
          const addDebuggerRecognizer = (el, key) => {
               el.setAttribute('data-debugger-recognizer-key', key)
               if(!_first) el.classList.add('hidden')
               _first = false
          }
     
          const makePages = (root, tabs) => {
               Object.keys(tabs).forEach(key => {
                    const wrap = document.createElement('div')
                    addDebuggerRecognizer(wrap, key)
                    wrap.classList.add('pt-5')
                    wrap.classList.add('pb-14')
                    const title = document.createElement('h2')
                    title.innerHTML = key.replace('_', ' ')
                    title.classList.add('text-4xl')
                    title.classList.add('my-8')
                    wrap.appendChild(title)
                    const fields = tabs[key]
                    fields.forEach(field => {
                         if(field.title) {
                              const el = document.createElement('h3')
                              el.classList.add('text-2xl')
                              el.classList.add('my-2')
                              el.innerHTML = field.title
                              wrap.appendChild(el)
                         } else if(field.miniCodeBlock) {
                              const elw = document.createElement('pre')
                              const el = document.createElement('code')
                              elw.classList.add('my-2')
                              elw.classList.add('___debug_code_block')
                              el.classList.add('p-2')
                              // if(field.type == 'jswc') el.innerHTML = atob(field.miniCodeBlock)
                              // else el.innerHTML = field.miniCodeBlock
                              el.innerHTML = field.miniCodeBlock
                              elw.appendChild(el)

                              if(field.dropdown) {
                                   el.classList.add('!flex')
                                   el.classList.add('items-center')
                                   const btn_more = document.createElement('button')
                                   btn_more.innerHTML = '&#8505;'
                                   btn_more.classList.add('rounded')
                                   btn_more.classList.add('py-0.5')
                                   btn_more.classList.add('px-2')
                                   btn_more.classList.add('bg-yellow-300')
                                   btn_more.classList.add('text-gray-900')
                                   btn_more.classList.add('ml-auto')
                                   const ddel = document.createElement('div')
                                   ddel.classList.add('hidden')
                                   ddel.innerHTML = field.dropdown
                                   ddel.classList.add('px-3')
                                   ddel.classList.add('py-2')
                                   ddel.classList.add('border-t-4')
                                   ddel.classList.add('border-gray-900')
                                   
                                   btn_more.addEventListener('click', () => {
                                        ddel.classList.toggle('hidden')
                                   })
                                   el.appendChild(btn_more)

                                   elw.appendChild(ddel)
                              }

                              wrap.appendChild(elw)
                         }
                    })
                    root.appendChild(wrap)
               })
          }
     
          makeTabs(vars.tabs)
          makePages(pages, vars.tabs)
     }
}