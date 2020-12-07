@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<table class="table">
					<thead>
						<tr>
							<th>Title</th>
							<th>Description</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($entries as $entry)
						<tr>
							<td>{{ $entry->title }}</td>
							<td>{{ $entry->description }}</td>
							<td>
								<a href="{{ route('entries.show', $entry) }}">view</a>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="3" class="text-center">
								No entry found
								<a href="{{ route('entries.create') }}" >Add Entry</a>
							</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection