@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							Entries
						</div>
						<div class="col-md-6 text-right">
							<a href="{{ route('entries.create') }}" class="btn btn-success">Add</a>
						</div>
					</div>
				</div>
				<table class="table table-hover">
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
							<td class="text-right">
								<a class="btn btn-primary" href="{{ route('entries.show', $entry) }}">view</a>
								<a class="btn btn-secondary" href="{{ route('entries.edit', $entry) }}">Edit</a>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="3" class="text-center">
								No entry found
								<a href="{{ route('entries.create') }}" >Add an entry</a>
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