<div class="m-portlet__foot m-portlet__foot--fit">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
            {!! Session::get('success') !!}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
            {!! Session::get('error') !!}
        </div>
    @endif
	<div class="m-form__actions">
		<button type="submit" class="btn btn-success m-btn m-btn--icon">
			<span>
				<i class="fa fa-save"></i>
				<span>{{ __('forms.save') }}</span>
			</span>
		</button>

		<button type="reset" class="btn btn-secondary m-btn m-btn--icon">
			<span>
				<i class="fa fa-undo"></i>
				<span>{{ __('forms.reset') }}</span>
			</span>
		</button>
	</div>
</div>
