<?php

$state = $value ? 'success' : 'danger';
$label = $value ? __('global.yes') : __('global.no');

?>

<span class="m-badge m-badge--{{ $state }} m-badge--wide">{{ $label }}</span>