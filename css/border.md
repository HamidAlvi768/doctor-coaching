.card {
isolation: isolate;
}

.media-object {
--border-width: 1px;
--radius: 24px;

position: relative;
border-radius: var(--radius);
border: var(--border-width) solid transparent;
}

.media-object::before {
content: " ";
position: absolute;
inset: calc(var(--border-width) \* -1);
z-index: -1;
border: inherit;
border-radius: inherit;
background-image: conic-gradient(from var(--angle), #381D6A 80%, #E0D1FF 88%, #E0D1FF 92%, #381D6A 100%);
background-origin: border-box;
-webkit-mask:
linear-gradient(black, black) content-box,
linear-gradient(black, black);  
 mask: linear-gradient(black, black),
linear-gradient(black, black);
-webkit-mask-clip: content-box, border-box;  
 mask-clip: content-box, border-box;
-webkit-mask-composite: xor;  
 mask-composite: exclude;
animation: spin 3s linear infinite;
}

@supports not (background: paint(something)) {
.media-object::before {
background-image: conic-gradient(#381D6A 80%, #E0D1FF 88%, #E0D1FF 92%, #381D6A 100%);  
 }
}

.media-object:hover::before {
animation-play-state: paused;
}

@property --angle {
syntax: "<angle>";
inherits: true;
initial-value: 0turn;
}

@keyframes spin {
to {
--angle: 1turn;
}
}

html {
box-sizing: border-box;
scroll-behavior: smooth;
}

@media (prefers-reduced-motion) {
html {
scroll-behavior: none;
}
}

html _,
html _::after,
html \*::before {
box-sizing: inherit;
}

body {
margin: 0;
min-height: 100vh;
display: grid;
place-items: center;
background-size: cover;
background-position: center;
background-image: url("https://i.imgur.com/YvUPGUK.jpg");
font: 100%/1.6 'Open Sans', sans-serif;
}

.card {
--text-color: #fff;
--text-color-2: #F3F8FA;
--bg-color: #0F0620;
--border-color: #381D6A;

display: flex;
flex-direction: column;
gap: 24px;
width: 644px;
padding: 32px;
border-radius: 24px;
color: var(--text-color);
background: var(--bg-color);
border: 1px solid var(--border-color);
font: 100%/1.6 'Open Sans', sans-serif;
}

.card\_\_title {
margin-block: 0;
font-family: 'Sora', sans-serif;
font-size: 33px;
font-weight: 700;
line-height: 44px;
}

mark {
background: linear-gradient(270deg, #D42F4A 0%, #F82BBF 100%);
-webkit-background-clip: text;
background-clip: text;
-webkit-text-fill-color: #0000;
-webkit-box-decoration-break: clone;
}

.card\_\_description {
color: var(--text-color-2);
line-height: 24px;
margin-block: 0;
}

.card\_\_actions {
display: flex;
gap: 24px;
}

.card\_\_button {
display: block;
padding: 16px 32px;
border: 1px solid var(--border-color);
border-radius: 24px;
text-decoration: none;
color: inherit;
flex-grow: 1;
text-align: center;
font-weight: 600;
line-height: 16px;
}

.media-object {
display: flex;
justify-content: space-between;
align-items: end;
padding: 24px;
gap: 24px;
}

.media-object\_\_title {
font-size: 18px;
font-weight: 600;
line-height: 27px;
margin: 0 0 16px;
}

.media-object\_\_button {
display: flex;
align-items: center;
width: fit-content;
gap: 8px;
padding: 16px 38px 14px;
border-radius: 28px;
background: linear-gradient(270deg, #E8488A 0%, #D5304B 100%);
color: #fff;
text-decoration: none;
font-family: 'Sora', sans-serif;
font-weight: 600;
line-height: 16px;
text-align: center;
}

.media-object\_\_thumbnail {
width: 280px;
height: 160px;
border-radius: 16px;
background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="280" height="160" fill="none"><g filter="url(%23a)"><g clip-path="url(%23b)"><rect width="280" height="160" fill="url(%23c)" rx="16"/><g filter="url(%23d)"><rect width="429.885" height="505" x="36" y="34" fill="%23fff" rx="12.762"/><rect width="260.025" height="43.869" x="51.935" y="49.935" fill="%23fff" rx="5.982"/><circle cx="69.446" cy="71.746" r="4.78" stroke="%239CA3AF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.196"/><path stroke="%239CA3AF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.196" d="m72.77 75.318 1.874 1.87"/><path fill="%236B7280" d="M91.51 74.597c0 .506-.127.938-.38 1.297-.25.354-.6.625-1.052.812-.452.186-.983.28-1.595.28-.323 0-.629-.016-.917-.047a6.23 6.23 0 0 1-.794-.134 3.375 3.375 0 0 1-.637-.216v-.953c.292.121.648.234 1.069.34.42.1.86.151 1.32.151.429 0 .79-.056 1.087-.17.296-.116.52-.282.672-.496.156-.218.233-.479.233-.783 0-.292-.064-.535-.192-.73-.129-.198-.343-.378-.643-.537a8.463 8.463 0 0 0-1.215-.52 6.535 6.535 0 0 1-.958-.42 2.985 2.985 0 0 1-.695-.527 1.982 1.982 0 0 1-.427-.677 2.572 2.572 0 0 1-.14-.882c0-.456.115-.846.345-1.169.233-.327.555-.576.964-.748.412-.175.885-.263 1.42-.263.455 0 .875.043 1.261.129.39.086.746.2 1.069.345l-.31.853a6.743 6.743 0 0 0-.981-.322 4.367 4.367 0 0 0-1.063-.128c-.366 0-.676.054-.93.163-.248.105-.44.255-.572.45a1.206 1.206 0 0 0-.198.695c0 .3.062.55.187.748.128.199.33.376.607.532.28.152.65.311 1.11.479.503.183.93.378 1.28.584.35.203.617.452.8.748.183.292.275.664.275 1.116Zm4.385-4.247c.545 0 1.012.12 1.402.362.39.241.687.58.894 1.016.206.433.31.939.31 1.52v.6h-4.423c.011.752.198 1.325.56 1.718.363.394.873.59 1.531.59.405 0 .764-.037 1.075-.11.312-.075.635-.184.97-.328v.853c-.323.144-.645.25-.964.316-.316.066-.69.099-1.122.099-.615 0-1.153-.125-1.612-.374a2.615 2.615 0 0 1-1.063-1.11c-.254-.487-.38-1.083-.38-1.787 0-.69.115-1.286.345-1.788.233-.507.56-.896.981-1.169.424-.272.923-.408 1.496-.408Zm-.012.794c-.518 0-.93.17-1.239.508-.307.34-.49.812-.549 1.42h3.389a2.738 2.738 0 0 0-.181-1.005 1.41 1.41 0 0 0-.52-.678c-.234-.163-.534-.245-.9-.245Zm6.979-.783c.763 0 1.33.171 1.7.514.37.343.555.89.555 1.642v4.352h-.707l-.187-.946h-.047c-.179.233-.366.43-.561.59-.194.156-.42.274-.677.356a3.218 3.218 0 0 1-.935.117c-.389 0-.736-.068-1.04-.205a1.623 1.623 0 0 1-.713-.619c-.171-.276-.257-.627-.257-1.051 0-.639.254-1.13.76-1.473.506-.342 1.277-.53 2.313-.56l1.104-.047v-.391c0-.553-.118-.941-.356-1.163-.238-.222-.572-.333-1.005-.333a3.12 3.12 0 0 0-.958.146 6.495 6.495 0 0 0-.864.345l-.298-.736c.288-.148.619-.275.993-.38a4.34 4.34 0 0 1 1.18-.158Zm1.297 3.353-.976.041c-.798.032-1.361.162-1.688.392-.327.23-.491.555-.491.975 0 .367.111.637.333.812.222.176.516.263.882.263.569 0 1.034-.157 1.396-.473.363-.315.544-.789.544-1.42v-.59Zm6.184-3.364c.129 0 .263.007.403.023.14.012.265.03.374.052l-.123.9a3.036 3.036 0 0 0-.712-.088 1.74 1.74 0 0 0-1.326.602c-.172.191-.306.423-.404.695a2.635 2.635 0 0 0-.146.9v3.435h-.975v-6.403h.806l.105 1.18h.041a3.12 3.12 0 0 1 .479-.648 2.15 2.15 0 0 1 .649-.473c.249-.117.525-.175.829-.175Zm4.87 6.636c-.576 0-1.085-.119-1.525-.356-.44-.238-.783-.6-1.028-1.087s-.368-1.1-.368-1.84c0-.775.129-1.408.386-1.899.261-.495.619-.86 1.075-1.098.455-.238.973-.356 1.554-.356.319 0 .627.033.923.099.299.062.545.142.736.24l-.292.811a5.039 5.039 0 0 0-.678-.21 2.986 2.986 0 0 0-.713-.093c-.444 0-.814.095-1.11.286-.292.19-.512.471-.66.841-.144.37-.216.826-.216 1.367 0 .518.07.96.21 1.326.144.366.357.647.637.842.284.19.639.286 1.063.286.339 0 .645-.035.917-.105.273-.074.52-.16.742-.258v.865c-.214.11-.453.193-.718.251a4.338 4.338 0 0 1-.935.088Zm4.461-9.207v2.717c0 .155-.004.313-.012.473a4.15 4.15 0 0 1-.041.432h.065c.132-.226.3-.415.502-.567a2.2 2.2 0 0 1 .701-.35c.261-.082.538-.123.83-.123.514 0 .942.082 1.285.245.347.164.606.417.777.76.175.343.263.787.263 1.332v4.171h-.958v-4.107c0-.533-.123-.933-.368-1.197-.242-.265-.614-.398-1.116-.398-.475 0-.855.092-1.139.275-.281.18-.483.444-.608.795-.121.35-.181.778-.181 1.285v3.347h-.97v-9.09h.97Z"/><rect width="260.025" height="43.869" x="51.935" y="49.935" stroke="%23E5E7EB" stroke-width=".798" rx="5.982"/><path fill="%23fff" d="M51.536 105.855h319.05v30.795H51.536z"/><rect width="19.143" height="19.143" x="57.362" y="111.682" fill="url(%23e)" rx="3.191"/><rect width="34.02" height="12.762" x="84.273" y="114.872" fill="url(%23f)" rx="3.191"/><rect width="72.584" height="30.795" x="51.536" y="105.855" stroke="%23E5E7EB" stroke-width=".798" rx="6.381"/><rect width="19.143" height="19.143" x="139.518" y="111.682" fill="url(%23g)" rx="3.191"/><rect width="34.02" height="12.762" x="166.429" y="114.872" fill="url(%23h)" rx="3.191"/><rect width="72.584" height="30.795" x="133.691" y="105.855" stroke="%23E5E7EB" stroke-width=".798" rx="6.381"/><rect width="19.143" height="19.143" x="221.673" y="111.682" fill="url(%23i)" rx="3.191"/><rect width="34.02" height="12.762" x="248.584" y="114.872" fill="url(%23j)" rx="3.191"/><rect width="72.584" height="30.795" x="215.847" y="105.855" stroke="%23E5E7EB" stroke-width=".798" rx="6.381"/><path fill="%23fff" d="M51.536 148.303h398.812v231.103H51.536z"/><rect width="127.62" height="19.143" x="51.536" y="148.303" fill="url(%23k)" rx="6.381"/><rect width="437.885" height="513" x="32" y="30" stroke="%23fff" stroke-opacity=".25" stroke-width="8" rx="16.762"/></g><g filter="url(%23l)"><rect width="429.885" height="505" x="36" y="34" fill="%23fff" rx="12.762"/><rect width="260.025" height="43.869" x="51.935" y="49.935" fill="%23fff" rx="5.982"/><circle cx="69.446" cy="71.746" r="4.78" stroke="%239CA3AF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.196"/><path stroke="%239CA3AF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.196" d="m72.77 75.318 1.874 1.87"/><path fill="%236B7280" d="M91.51 74.597c0 .506-.127.938-.38 1.297-.25.354-.6.625-1.052.812-.452.186-.983.28-1.595.28-.323 0-.629-.016-.917-.047a6.23 6.23 0 0 1-.794-.134 3.375 3.375 0 0 1-.637-.216v-.953c.292.121.648.234 1.069.34.42.1.86.151 1.32.151.429 0 .79-.056 1.087-.17.296-.116.52-.282.672-.496.156-.218.233-.479.233-.783 0-.292-.064-.535-.192-.73-.129-.198-.343-.378-.643-.537a8.463 8.463 0 0 0-1.215-.52 6.535 6.535 0 0 1-.958-.42 2.985 2.985 0 0 1-.695-.527 1.982 1.982 0 0 1-.427-.677 2.572 2.572 0 0 1-.14-.882c0-.456.115-.846.345-1.169.233-.327.555-.576.964-.748.412-.175.885-.263 1.42-.263.455 0 .875.043 1.261.129.39.086.746.2 1.069.345l-.31.853a6.743 6.743 0 0 0-.981-.322 4.367 4.367 0 0 0-1.063-.128c-.366 0-.676.054-.93.163-.248.105-.44.255-.572.45a1.206 1.206 0 0 0-.198.695c0 .3.062.55.187.748.128.199.33.376.607.532.28.152.65.311 1.11.479.503.183.93.378 1.28.584.35.203.617.452.8.748.183.292.275.664.275 1.116Zm4.385-4.247c.545 0 1.012.12 1.402.362.39.241.687.58.894 1.016.206.433.31.939.31 1.52v.6h-4.423c.011.752.198 1.325.56 1.718.363.394.873.59 1.531.59.405 0 .764-.037 1.075-.11.312-.075.635-.184.97-.328v.853c-.323.144-.645.25-.964.316-.316.066-.69.099-1.122.099-.615 0-1.153-.125-1.612-.374a2.615 2.615 0 0 1-1.063-1.11c-.254-.487-.38-1.083-.38-1.787 0-.69.115-1.286.345-1.788.233-.507.56-.896.981-1.169.424-.272.923-.408 1.496-.408Zm-.012.794c-.518 0-.93.17-1.239.508-.307.34-.49.812-.549 1.42h3.389a2.738 2.738 0 0 0-.181-1.005 1.41 1.41 0 0 0-.52-.678c-.234-.163-.534-.245-.9-.245Zm6.979-.783c.763 0 1.33.171 1.7.514.37.343.555.89.555 1.642v4.352h-.707l-.187-.946h-.047c-.179.233-.366.43-.561.59-.194.156-.42.274-.677.356a3.218 3.218 0 0 1-.935.117c-.389 0-.736-.068-1.04-.205a1.623 1.623 0 0 1-.713-.619c-.171-.276-.257-.627-.257-1.051 0-.639.254-1.13.76-1.473.506-.342 1.277-.53 2.313-.56l1.104-.047v-.391c0-.553-.118-.941-.356-1.163-.238-.222-.572-.333-1.005-.333a3.12 3.12 0 0 0-.958.146 6.495 6.495 0 0 0-.864.345l-.298-.736c.288-.148.619-.275.993-.38a4.34 4.34 0 0 1 1.18-.158Zm1.297 3.353-.976.041c-.798.032-1.361.162-1.688.392-.327.23-.491.555-.491.975 0 .367.111.637.333.812.222.176.516.263.882.263.569 0 1.034-.157 1.396-.473.363-.315.544-.789.544-1.42v-.59Zm6.184-3.364c.129 0 .263.007.403.023.14.012.265.03.374.052l-.123.9a3.036 3.036 0 0 0-.712-.088 1.74 1.74 0 0 0-1.326.602c-.172.191-.306.423-.404.695a2.635 2.635 0 0 0-.146.9v3.435h-.975v-6.403h.806l.105 1.18h.041a3.12 3.12 0 0 1 .479-.648 2.15 2.15 0 0 1 .649-.473c.249-.117.525-.175.829-.175Zm4.87 6.636c-.576 0-1.085-.119-1.525-.356-.44-.238-.783-.6-1.028-1.087s-.368-1.1-.368-1.84c0-.775.129-1.408.386-1.899.261-.495.619-.86 1.075-1.098.455-.238.973-.356 1.554-.356.319 0 .627.033.923.099.299.062.545.142.736.24l-.292.811a5.039 5.039 0 0 0-.678-.21 2.986 2.986 0 0 0-.713-.093c-.444 0-.814.095-1.11.286-.292.19-.512.471-.66.841-.144.37-.216.826-.216 1.367 0 .518.07.96.21 1.326.144.366.357.647.637.842.284.19.639.286 1.063.286.339 0 .645-.035.917-.105.273-.074.52-.16.742-.258v.865c-.214.11-.453.193-.718.251a4.338 4.338 0 0 1-.935.088Zm4.461-9.207v2.717c0 .155-.004.313-.012.473a4.15 4.15 0 0 1-.041.432h.065c.132-.226.3-.415.502-.567a2.2 2.2 0 0 1 .701-.35c.261-.082.538-.123.83-.123.514 0 .942.082 1.285.245.347.164.606.417.777.76.175.343.263.787.263 1.332v4.171h-.958v-4.107c0-.533-.123-.933-.368-1.197-.242-.265-.614-.398-1.116-.398-.475 0-.855.092-1.139.275-.281.18-.483.444-.608.795-.121.35-.181.778-.181 1.285v3.347h-.97v-9.09h.97Z"/><rect width="260.025" height="43.869" x="51.935" y="49.935" stroke="%23E5E7EB" stroke-width=".798" rx="5.982"/><path fill="%23fff" d="M51.536 105.855h319.05v30.795H51.536z"/><rect width="19.143" height="19.143" x="57.362" y="111.682" fill="url(%23m)" rx="3.191"/><rect width="34.02" height="12.762" x="84.273" y="114.872" fill="url(%23n)" rx="3.191"/><rect width="72.584" height="30.795" x="51.536" y="105.855" stroke="%23E5E7EB" stroke-width=".798" rx="6.381"/><rect width="19.143" height="19.143" x="139.518" y="111.682" fill="url(%23o)" rx="3.191"/><rect width="34.02" height="12.762" x="166.429" y="114.872" fill="url(%23p)" rx="3.191"/><rect width="72.584" height="30.795" x="133.691" y="105.855" stroke="%23E5E7EB" stroke-width=".798" rx="6.381"/><rect width="19.143" height="19.143" x="221.673" y="111.682" fill="url(%23q)" rx="3.191"/><rect width="34.02" height="12.762" x="248.584" y="114.872" fill="url(%23r)" rx="3.191"/><rect width="72.584" height="30.795" x="215.847" y="105.855" stroke="%23E5E7EB" stroke-width=".798" rx="6.381"/><path fill="%23fff" d="M51.536 148.303h398.812v231.103H51.536z"/><rect width="127.62" height="19.143" x="51.536" y="148.303" fill="url(%23s)" rx="6.381"/><rect width="428.885" height="504" x="36.5" y="34.5" stroke="%23EDEEEF" rx="12.262"/></g></g></g><defs><linearGradient id="c" x1="427.5" x2="0" y1="80" y2="80" gradientUnits="userSpaceOnUse"><stop stop-color="%23F42CB2"/><stop offset="1" stop-color="%232D047A"/></linearGradient><linearGradient id="e" x1="72.916" x2="42.108" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="f" x1="111.915" x2="57.163" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="g" x1="155.071" x2="124.263" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="h" x1="194.07" x2="139.319" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="i" x1="237.227" x2="206.418" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="j" x1="276.226" x2="221.474" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="k" x1="155.227" x2="-50.161" y1="157.874" y2="157.874" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="m" x1="72.916" x2="42.108" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="n" x1="111.915" x2="57.163" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="o" x1="155.071" x2="124.263" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="p" x1="194.07" x2="139.319" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="q" x1="237.227" x2="206.418" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="r" x1="276.226" x2="221.474" y1="121.253" y2="121.253" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><linearGradient id="s" x1="155.227" x2="-50.161" y1="157.874" y2="157.874" gradientUnits="userSpaceOnUse"><stop stop-color="%23F9FAFB"/><stop offset="1" stop-color="%23E5E7EB"/></linearGradient><filter id="a" width="280" height="160" x="0" y="0" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feBlend in="SourceGraphic" in2="BackgroundImageFix" result="shape"/><feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset/><feGaussianBlur stdDeviation="6"/><feComposite in2="hardAlpha" k2="-1" k3="1" operator="arithmetic"/><feColorMatrix values="0 0 0 0 0.54902 0 0 0 0 0.572549 0 0 0 0 0.6 0 0 0 0.12 0"/><feBlend in2="shape" result="effect1_innerShadow_1776_178"/></filter><filter id="d" width="706.885" height="923" x="-187" y="4" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset dx="-6" dy="17"/><feGaussianBlur stdDeviation="19.5"/><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/><feBlend in2="BackgroundImageFix" result="effect1_dropShadow_1776_178"/><feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset dx="-25" dy="67"/><feGaussianBlur stdDeviation="35.5"/><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.09 0"/><feBlend in2="effect1_dropShadow_1776_178" result="effect2_dropShadow_1776_178"/><feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset dx="-57" dy="150"/><feGaussianBlur stdDeviation="48"/><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend in2="effect2_dropShadow_1776_178" result="effect3_dropShadow_1776_178"/><feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset dx="-101" dy="266"/><feGaussianBlur stdDeviation="57"/><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.01 0"/><feBlend in2="effect3_dropShadow_1776_178" result="effect4_dropShadow_1776_178"/><feBlend in="SourceGraphic" in2="effect4_dropShadow_1776_178" result="shape"/></filter><filter id="l" width="690.885" height="907" x="-179" y="12" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset dx="-6" dy="17"/><feGaussianBlur stdDeviation="19.5"/><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/><feBlend in2="BackgroundImageFix" result="effect1_dropShadow_1776_178"/><feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset dx="-25" dy="67"/><feGaussianBlur stdDeviation="35.5"/><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.09 0"/><feBlend in2="effect1_dropShadow_1776_178" result="effect2_dropShadow_1776_178"/><feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset dx="-57" dy="150"/><feGaussianBlur stdDeviation="48"/><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend in2="effect2_dropShadow_1776_178" result="effect3_dropShadow_1776_178"/><feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/><feOffset dx="-101" dy="266"/><feGaussianBlur stdDeviation="57"/><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.01 0"/><feBlend in2="effect3_dropShadow_1776_178" result="effect4_dropShadow_1776_178"/><feBlend in="SourceGraphic" in2="effect4_dropShadow_1776_178" result="shape"/></filter><clipPath id="b"><rect width="280" height="160" fill="%23fff" rx="16"/></clipPath></defs></svg>');
}

.source-link {
position: fixed;
right: 32px;
bottom: 32px;  
 width: fit-content;
box-sizing: border-box;
font-size: 16px;
display: flex;
padding: 0.75em 1em 0.75em 0.75em;
justify-content: center;
align-items: center;
gap: 0.5em;
border-radius: 128px;
background: linear-gradient(270deg, #AFE8EF 0%, #E7E1FA 100%);
color: #000;
text-align: center;
font-style: normal;
font-weight: 400;
line-height: 150%;
text-decoration: none;
}

.source-link svg {
display: block;
width: 1.5em;
height: 1.5em;
border-radius: 0.25em;
}

.source-link.source-link--second {
right: auto;
left: 32px;
}
