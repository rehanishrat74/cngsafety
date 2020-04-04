  
  <span class="input-group-addon" onclick="location.href = '{{$loc}}';"> 

to open a new window
<span class="input-group-addon" onclick="window.open('{{$loc}}','popUpWindow','height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no',); return false;" >

to open a new tab
<span class="input-group-addon" onclick="window.open('{{$loc}}'); return false;" >

window.location.href = '{{route($targetroute)}}'; 