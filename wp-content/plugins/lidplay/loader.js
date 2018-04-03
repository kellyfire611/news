/*  Copyright 2017  LidPlay  (email: contact@lidplay.net)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function lidplay(t,e,r){function l(t){var e=[];for(var r in t)e.push(encodeURIComponent(r)+"="+encodeURIComponent(t[r]));return e.join("&")}function u(t,e){return t.indexOf(e)>-1}function n(t,e){if("[object String]"==Object.prototype.toString.call(e))return u(t,e);for(var r=0;r<e.length;r++)if(u(t,e[r]))return!0;return!1}function i(t){var e=t.getBoundingClientRect(),r=e.top,l=e.bottom;return r<window.innerHeight&&l>=0}function o(t){return"none"===window.getComputedStyle(t).display}setInterval(function(){for(var s=document.getElementsByTagName("iframe"),a=0;a<s.length;a++)!u(s[a].src,e)&&n(s[a].src,r)&&i(s[a])&&!o(s[a])&&(t.url=s[a].src,s[a].getAttribute("subtitles_src")?t.subtitles_src=s[a].getAttribute("subtitles_src"):delete t.subtitles_src,s[a].getAttribute("subtitles_label")?t.subtitles_label=s[a].getAttribute("subtitles_label"):delete t.subtitles_label,s[a].getAttribute("default_resolution")?t.default_resolution=s[a].getAttribute("default_resolution"):delete t.default_resolution,s[a].getAttribute("start")?t.start=s[a].getAttribute("start"):delete t.start,s[a].getAttribute("autoplay")?t.autoplay=s[a].getAttribute("autoplay"):delete t.autoplay,s[a].src=e+l(t),s[a].setAttribute("allowfullscreen",""),s[a].setAttribute("mozallowfullscreen",""),s[a].setAttribute("webkitallowfullscreen",""),s[a].removeAttribute("sandbox"))},500)}