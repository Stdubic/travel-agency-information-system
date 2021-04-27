<div class="m-portlet__head">
	<div class="m-portlet__head-wrapper">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="{{ $icon }}"></i>
				</span>
                <h3 class="m-portlet__head-text m--font-primary">{{ strtoupper($title) }}</h3>
                <span id="page-title" hidden>{{ $title }}</span>
            </div>
        </div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<a href="{{ url()->previous() }}" title="{{ __('global.back') }}" data-container="body" data-toggle="m-tooltip" data-placement="top" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-arrow-left"></i></a>
				</li>
				<li class="m-portlet__nav-item">
					<a href="{{ url()->full() }}" title="{{ __('global.refresh') }}" data-container="body" data-toggle="m-tooltip" data-placement="top" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-refresh"></i></a>
				</li>
				<li class="m-portlet__nav-item">
					<a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
				</li>
				<li class="m-portlet__nav-item">
					<a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-expand"></i></a>
				</li>
			</ul>
            @if(isset($path))
            <a href="{{ route($path) }}" class="btn btn-success m-btn m-btn--icon m--margin-left-10">
					<span>
						<i class="fa fa-plus"></i>
						<span>{{ __('global.add') }}</span>
					</span>
            </a>
            @endif
		</div>
	</div>
</div>
