<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<title>{{ env('APP_NAME') }}</title>
		@include('base::layouts.header')

		<link rel="stylesheet" type="text/css" href="{{ asset('metronic/vendors/custom/datatables/datatables.bundle.css') }}">
		<link rel="stylesheet" type="text/css" href="https://amcharts.com/lib/3/plugins/export/export.css">

		<script defer src="{{ asset('metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
		<script defer src="https://amcharts.com/lib/3/amcharts.js"></script>
		<script defer src="https://amcharts.com/lib/3/serial.js"></script>
		<script defer src="https://amcharts.com/lib/3/plugins/animate/animate.min.js"></script>
		<script defer src="https://amcharts.com/lib/3/plugins/export/export.min.js"></script>
	</head>
	<body onload="mainInit();" onbeforeunload="blockPage();" class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<header id="m_header" class="m-grid__item m-header" m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-brand  m-brand--skin-dark">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="{{ route('home') }}" class="m-brand__logo-wrapper">
										<img data-src="{{ asset('img/logo.png') }}" alt="Logo" width="150" class="lazy-load">
									</a>
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">
									<!-- BEGIN: Left Aside Minimize Toggle -->
									<a href="#" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block
					 ">
										<span></span>
									</a>
									<!-- END -->
									<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="#" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>
									<!-- END -->
									<!-- BEGIN: Topbar Toggler -->
									<a id="m_aside_header_topbar_mobile_toggle" href="#" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
										<i class="flaticon-more"></i>
									</a>
									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
						</div>

						<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
							<div id="m_header_topbar" class="m-topbar m-stack m-stack--ver m-stack--general m-stack--fluid">
								<div class="m-stack__item m-topbar__nav-wrapper">

									<ul class="m-topbar__nav m-nav m-nav--inline">
										<?php

										$locales = config('custom.locales');

										if(count($locales) > 1)
										{
											sort($locales);
											$curr_locale = app()->getLocale();

											?>
											<li class="m-nav__item m-topbar__languages m-dropdown m-dropdown--small m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width" m-dropdown-toggle="click">
												<a href="#" class="m-nav__link m-dropdown__toggle">
													<span class="m-nav__link-text">
														<img class="m-topbar__language-selected-img" src="{{ asset('img/flags/'.$curr_locale.'.svg') }}">
													</span>
												</a>
												<div class="m-dropdown__wrapper">
													<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
													<div class="m-dropdown__inner">
														<div class="m-dropdown__header m--align-center" style="background: url('{{ asset('img/misc/quick_actions_bg.jpg') }}'); background-size: cover;">
															<span class="m-dropdown__header-subtitle">{{ __('global.select-lang') }}</span>
														</div>
														<div class="m-dropdown__body">
															<div class="m-dropdown__content">
																<ul class="m-nav m-nav--skin-light">
																	<?php

																	foreach($locales as $locale)
																	{
																		$active = $locale == $curr_locale ? 'm-nav__item--active' : '';

																		?>
																		<li class="m-nav__item {{ $active }}">
																			<a href="{{ route('change-locale', $locale) }}" class="m-nav__link">
																				<span class="m-nav__link-icon"><img class="m-topbar__language-img" src="{{ asset('img/flags/'.$locale.'.svg') }}"></span>
																				<span class="m-nav__link-title m-topbar__language-text m-nav__link-text">{{ strtoupper($locale) }}</span>
																			</a>
																		</li>
																		<?php
																	}

																	?>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</li>
											<?php
										}

										?>
										<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													@include('base::layouts.profile_area')
												</span>
												<span class="m-topbar__username m--hide">{{ Auth::user()->name }}</span>
											</a>
											<div class="m-dropdown__wrapper">
												<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
												<div class="m-dropdown__inner">
													<div class="m-dropdown__header m--align-center" style="background: url('{{ asset('img/misc/user_profile_bg.jpg') }}'); background-size: cover;">
														<div class="m-card-user m-card-user--skin-dark">
															<div class="m-card-user__pic">
																@include('base::layouts.profile_area')
															</div>
															<div class="m-card-user__details">
																<span class="m-card-user__name m--font-weight-500">{{ Auth::user()->name }}</span>
																<a href="mailto:{{ Auth::user()->email }}" class="m-card-user__email m--font-weight-300 m-link">{{ Auth::user()->email }}</a>
															</div>
														</div>
													</div>
													<div class="m-dropdown__body">
														<div class="m-dropdown__content">
															<ul class="m-nav m-nav--skin-light">
																<li class="m-nav__item">
																	{{--<a href="{{ $user->profile() }}" class="m-nav__link">--}}
																	<a href="" class="m-nav__link">
																		<i class="m-nav__link-icon fa fa-user-edit"></i>
																		<span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">{{ __('global.profile') }}</span>
																			</span>
																		</span>
																	</a>
																</li>
																<li class="m-nav__item">
																	<a href="{{ route('logout') }}" class="m-nav__link">
																		<i class="m-nav__link-icon fa fa-sign-out-alt"></i>
																		<span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">{{ __('global.logout') }}</span>
																			</span>
																		</span>
																	</a>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>
									</ul>

								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				<button type="button" class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
					<i class="la la-close"></i>
				</button>

				<div id="m_aside_left" class="m-grid__item m-aside-left m-aside-left--skin-dark">
					<!-- Side Content -->
					<div
						id="m_ver_menu"
						class="m-aside-menu m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark"
						m-menu-vertical="1"
						m-menu-scrollable="1"
						m-menu-dropdown-timeout="500"
						style="position: relative;">
							@include('base::layouts.navigation')
					</div>
					<!-- END Side Content -->
				</div>

				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<div class="m-content">
						<div class="m-portlet m-portlet--bordered m-portlet--rounded m-portlet--responsive-mobile" id="main_portlet">
							@yield('content')
						</div>
					</div>
				</div>
			</div>

			<footer class="m-grid__item	m-footer">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								{{ __('global.powered-by') }}
								<a href="{{ config('custom.dev_url') }}" class="m-link" target="_blank" rel="author">{{ config('custom.dev_name') }}</a>
							</span>
						</div>
						<?php

						if(count($errors))
						{
							?>
							<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
								<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
									<li class="m-nav__item">
										<a href="javascript:displayErrors('error-messages');" title="{{ __('global.errors') }}" class="m-nav__link" data-container="body" data-toggle="m-tooltip" data-placement="top">
											<span class="m-badge m-badge--danger m-badge--wide">
												<i class="fa fa-exclamation-triangle"></i> {{ count($errors) }}
											</span>
										</a>
									</li>
								</ul>
							</div>
							<?php
						}

						?>
					</div>
				</div>
			</footer>
		</div>

		<div id="m_scroll_top" class="m-scroll-top" title="{{ __('global.back-to-top') }}" data-container="body" data-toggle="m-tooltip" data-placement="top">
			<i class="la la-arrow-up"></i>
		</div>

		<span id="error-messages" hidden>{{ json_encode($errors->all()) }}</span>

		{{--<form id="logout-form" action="{{ route('logout') }}" method="post" hidden>--}}
			{{--@csrf--}}
		{{--</form>--}}
	</body>
</html>
