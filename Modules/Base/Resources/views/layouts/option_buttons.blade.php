<?php

if(isset($path) && getUser()->canViewRoute(key($path)))
{
	?>
	<a href="{{ route(key($path), current($path)) }}" title="{{ __('global.edit') }}" data-container="body" data-toggle="m-tooltip" data-placement="left" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
		<i class="fa fa-edit"></i>
	</a>
	<?php
}

if(isset($value))
{
	?>
	<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--primary">
		<input type="checkbox" name="values[]" value="{{ $value }}" class="options-form"><span></span>
	</label>
	<?php
}