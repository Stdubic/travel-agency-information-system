<?php

if(isset($actions))
{
	$action_types = [
		'remove' => [
			'label' => __('action-buttons.remove'),
			'method' => 'DELETE',
			'state_class' => 'danger',
			'icon_class' => 'fa fa-trash-alt'
		],
		'activate' => [
			'label' => __('action-buttons.activate'),
			'method' => 'PATCH',
			'state_class' => 'warning',
			'icon_class' => 'fa fa-toggle-on'
		],
		'test-api' => [
			'url' => true,
			'label' => __('action-buttons.test-api'),
			'method' => 'GET',
			'state_class' => 'info',
			'icon_class' => 'fa fa-external-link-alt'
		],
		'deactivate' => [
			'label' => __('action-buttons.deactivate'),
			'method' => 'PATCH',
			'state_class' => 'warning',
			'icon_class' => 'fa fa-toggle-off'
		],
		'fire-notification' => [
			'label' => __('action-buttons.send-notification'),
			'method' => 'POST',
			'state_class' => 'info',
			'icon_class' => 'fa fa-broadcast-tower'
		],
		'modal-leaderboard' => [
			'label' => 'Leaderboard',
			'method' => 'GET',
			'state_class' => 'primary',
			'icon_class' => 'fa fa-sort-numeric-up',
			'attributes' => [
				'data-toggle' => 'modal',
				'data-target' => '#leaderboard-modal'
			]
		]
	];

	foreach($actions as $action)
	{
		$type = trim($action['type']);
		if(!array_key_exists($type, $action_types)) continue;

		$is_modal = isset($action_types[$type]['attributes']);

		if(is_string($action['action']))
		{
			$route = $action['action'];
			$form_action = $is_modal ? $route : route($route);
		}
		else
		{
			$route = key($action['action']);
			$form_action = route($route, current($action['action']));
		}

//		if(!$is_modal && !getUser()->canViewRoute($route)) continue;

		$is_url = isset($action_types[$type]['url']) && $action_types[$type]['url'];
		$method = $action_types[$type]['method'];
		$state_class = $action_types[$type]['state_class'];
		$icon_class = $action_types[$type]['icon_class'];
		$label = $action_types[$type]['label'];
		$form_id = mt_rand();

		if($is_modal)
		{
			$attributes = $action_types[$type]['attributes'];
			$attributes['onclick'] = $form_action;

			foreach($attributes as $key => &$value)
			{
				if(is_bool($value))
				{
					if($value) $value = $key;
					else continue;
				}
				else $value = $key."='".$value."'";
			}

			$attributes = implode(' ', $attributes);
		}
		else $attributes = 'form="form-'.$form_id.'" onclick="gatherFormInputs(this.form);"';

		if($is_url)
		{
			?>
			<a href="{{ $form_action }}" target="_blank" class="dropdown-item">
				<i class="{{ $icon_class }}"></i>
				<span class="m--font-{{ $state_class }}">{{ $label }}</span>
			</a>
			<?php

			continue;
		}

		?>
		<button type="button" <?= $attributes ?> class="dropdown-item">
			<i class="{{ $icon_class }}"></i>
			<span class="m--font-{{ $state_class }}">{{ $label }}</span>
			<?php

			if(!$is_modal)
			{
				?>
				<form action="{{ $form_action }}" method="post" id="form-{{ $form_id }}" hidden>
					@csrf
					@method($method)
				</form>
				<?php
			}

			?>
		</button>
		<?php
	}
}
