<ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow">
	<?php

	$tab = Route::currentRouteName();
	$navbar_schema = config('navbar');

	foreach($navbar_schema as $page)
	{
		$type = $title = $icon_class = '';

		if(isset($page['type'])) $type = strtolower(trim($page['type']));
		if(isset($page['title'])) $title = __(trim($page['title']));
		if(isset($page['icon_class'])) $icon_class = trim($page['icon_class']);

		if($type == 'divider')
		{
			?>
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">{{ $title }}</h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
			<?php
		}
		else if(!isset($page['items']) || !count($page['items']))
		{
			$route = trim($page['route']);

			$is_active_class = $route == $tab ? 'm-menu__item--active' : '';
			$target = $page['target'] ?? '';

			?>
            @can($page['permission'])
                <li class="m-menu__item {{ $is_active_class }}" aria-haspopup="true">
                    @if(isset($page['id']))
                        <a href="{{ route($route) }}" target="{{ $target }}" id="{{$page['id']}}" class="m-menu__link">
                    @else
                        <a href="{{ route($route) }}" target="{{ $target }}" class="m-menu__link">
                    @endif
                        <i class="m-menu__link-icon {{ $icon_class }}"></i>
                        <span class="m-menu__link-title">
                            <span class="m-menu__link-wrap">
                                <span class="m-menu__link-text">{{ $title }}</span>
                            </span>
                        </span>
                    </a>
                </li>
            @endcan
			<?php
		}
		else
		{
			$items = $page['items'];
			$items_check = false;
			$is_open_class = '';

			foreach($items as $item)
			{
				$route = trim($item['route']);
				if($route == $tab) $is_open_class = 'm-menu__item--open';
				$items_check = true;
			}

			if(!$items_check) continue;
			?>
            <li class="m-menu__item m-menu__item--submenu {{ $is_open_class }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                @can($page['permission'])
                    @if(isset($page['id']))
                        <a href="javascript:;" id="{{$page['id']}}" class="m-menu__link m-menu__toggle">
                    @else
                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    @endif
                        <i class="m-menu__link-icon {{ $icon_class }}"></i>
                        <span class="m-menu__link-text">{{ $title }}</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                @endcan
                <div class="m-menu__submenu">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__link-text">{{ $title }}</span>
                            </span>
                        </li>
                        <?php
                        foreach($items as $key => $item)
                        {
                            $route = trim($item['route']);
                            $title = __(trim($item['title']));
                            $is_active_class = $route == $tab ? 'm-menu__item--active' : '';
                            $target = $item['target'] ?? '';
                            ?>
                            @can($item['permission'])
                                <li class="m-menu__item {{ $is_active_class }}" aria-haspopup="true">
                                    @if(isset($page['id']))
                                        <a href="{{ route($route) }}" target="{{ $target }}" id="{{$page['id']}}" class="m-menu__link">
                                    @else
                                        <a href="{{ route($route) }}" target="{{ $target }}" class="m-menu__link">
                                    @endif
                                    @if(isset($item['create']) && $item['create'] === true)
                                        <span class="m-menu__link-text">{{ $title }}</span><i class="m-menu__link-icon flaticon-add-circular-button"><span></span></i>
                                    @else
                                        <span class="m-menu__link-text">{{ $title }}</span>
                                    @endif
                                    </a>
                                </li>
                                @if(isset($item['create']) && $item['create'] === true)
                                    <hr>
                                @endif
                            @endcan
                            @if($key === (count($items)-1))
                                <br>
                            @endif
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </li>
			<?php
		}
	}

	?>
	<li class="m-menu__section">
		<h4 class="m-menu__section-text">{{ Auth::user()->name }}</h4>
		<i class="m-menu__section-icon flaticon-more-v3"></i>
	</li>
	<li class="m-menu__item m-menu__item" aria-haspopup="true">
		<a href="{{ route('logout') }}" class="m-menu__link">
			<i class="m-menu__link-icon fa fa-sign-out-alt"></i>
			<span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
					<span class="m-menu__link-text">{{ __('global.logout') }}</span>
				</span>
			</span>
		</a>
	</li>
</ul>
