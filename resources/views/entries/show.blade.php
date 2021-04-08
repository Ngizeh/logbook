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
                            <span class="text-sm">{{ $entry->formatted_date }}</span>
						</div>
						<div class="col-md-6 text-right">
							{{ $entry->category->name }}
						</div>
					</div>
				</div>

				<div class="card-body">
					{{ $entry->short_description }}
				</div>
				<div class="card-footer text-center">
					<a href="{{ route('entries.edit', $entry) }}">Edit Entry</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection



