@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							{{ $entry->title }}
						</div>
						<div class="col-md-6 text-right">
							{{ $entry->type }}
						</div>
					</div>
				</div>

				<div class="card-body">
					{{ $entry->description }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection



