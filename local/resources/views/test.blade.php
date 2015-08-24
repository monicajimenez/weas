<?php

$test ="monica";

if(isset($test))
echo "if";
else
echo "else";

if(!$test)
	echo "empty";
else
	echo "not empty";
?>

 @if( isset($test) && $test == 1 )
              <th data-field="status" class="center-align">
                 Status
              </th>
@endif

<div class="valign-wrapper">
  <h5 class="valign">This should be vertically aligned</h5>
</div>