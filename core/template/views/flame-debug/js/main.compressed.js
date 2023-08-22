// space because of the flameCore import...
class FlameCoreDebugApplication{makeResizableDiv(e){const t=document.querySelector(e);var d=document.querySelectorAll(e+" .resizer");const l=window.innerHeight-50;let s=0,a=0,n=0;for(let e=0;e<d.length;e++){function c(e){var d=s-(e.pageY-n);d>20&&d<l&&(t.style.height=d+"px",t.style.top=a+(e.pageY-n)+"px")}function r(){window.removeEventListener("mousemove",c)}d[e].addEventListener("mousedown",(function(e){e.preventDefault(),s=parseFloat(getComputedStyle(t,null).getPropertyValue("height").replace("px","")),a=t.getBoundingClientRect().top,n=e.pageY,window.addEventListener("mousemove",c),window.addEventListener("mouseup",r)}))}}createDebuggerPopupBar=e=>{const t=document.querySelector(`[${e.attribute}="button:${e.appId}"]`),d=`[${e.attribute}="app:${e.appId}"]`,l=document.querySelector(d),s=document.querySelector(`${d}>[debugger_tabs]`),a=document.querySelector(`${d}>[debugger_pages]`);t.addEventListener("click",(()=>{l.classList.toggle("fldb-hidden")}));const n=e=>{const t=e.target,d=e.target.innerText,l=document.querySelector(`[data-debugger-recognizer-key="${d}"]`);Object.keys(s.children).forEach((e=>{const t=s.children[e];if(t.hasAttribute("debugger__tab_selected")){t.removeAttribute("debugger__tab_selected");document.querySelector(`[data-debugger-recognizer-key="${t.innerText}"]`).classList.add("fldb-hidden")}})),t.setAttribute("debugger__tab_selected",!0),l.classList.remove("fldb-hidden")};let c=!0;(e=>{let t=!0;const d="fldb-transition fldb-duration-150 fldb-cursor-pointer fldb-flex fldb-flex-col fldb-bg-gray-900 fldb-text-xl fldb-px-5 fldb-py-2 fldb-h-full hover:fldb-bg-gray-950 fldb-border-r";Object.keys(e).forEach((e=>{const l=document.createElement("div");d.split(" ").forEach((e=>{l.classList.add(e)})),t&&(l.setAttribute("debugger__tab_selected",!0),l.classList.add("fldb-border-l"),t=!1),l.innerText=e.replace("_"," "),l.addEventListener("click",n),s.append(l)}));const a=document.createElement("div");d.split(" ").forEach((e=>{e.startsWith("fldb-border")||a.classList.add(e)})),a.innerHTML="&times;",a.addEventListener("click",(()=>{l.classList.toggle("fldb-hidden")})),s.append(a)})(e.tabs),((e,t)=>{Object.keys(t).forEach((d=>{const l=document.createElement("div");((e,t)=>{e.setAttribute("data-debugger-recognizer-key",t),c||e.classList.add("fldb-hidden"),c=!1})(l,d),l.classList.add("fldb-pt-5"),l.classList.add("fldb-pb-14"),l.classList.add("fldb-overflow-scroll");const s=document.createElement("h2");s.innerHTML=d.replace("_"," "),s.classList.add("fldb-text-4xl"),s.classList.add("fldb-my-8"),l.appendChild(s);t[d].forEach((e=>{if(e.title){const t=document.createElement("h3");t.classList.add("fldb-text-2xl"),t.classList.add("fldb-my-2"),t.innerHTML=e.title,l.appendChild(t)}else if(e.miniCodeBlock){const t=document.createElement("pre"),d=document.createElement("div");if(t.classList.add("fldb-my-2"),t.classList.add("fldb-leading-relaxed"),t.classList.add("___debug_code_block"),d.classList.add("fldb-p-2"),d.innerHTML=e.miniCodeBlock,t.appendChild(d),e.dropdown){d.classList.add("!fldb-flex"),d.classList.add("fldb-items-center");const l=document.createElement("button");l.innerHTML="&#8505;",l.classList.add("fldb-rounded"),l.classList.add("fldb-py-0.5"),l.classList.add("fldb-px-2"),l.classList.add("fldb-bg-sunglow"),l.classList.add("fldb-text-gray-900"),l.classList.add("fldb-ml-auto");const s=document.createElement("div");s.classList.add("fldb-hidden"),s.innerHTML=e.dropdown,s.classList.add("fldb-px-3"),s.classList.add("fldb-py-2"),s.classList.add("fldb-border-t-4"),s.classList.add("fldb-border-gray-900"),l.addEventListener("click",(()=>{s.classList.toggle("fldb-hidden")})),d.appendChild(l),t.appendChild(s)}l.appendChild(t)}})),e.appendChild(l)}))})(a,e.tabs)}}