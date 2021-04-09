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
				<table class="table">
					<thead>
						<tr>
                            <th>Date</th>
							<th>Title</th>
							<th>Description</th>
							<th>Category</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@forelse($entries as $entry)
						<tr>
                            <td>{{ $entry->formatted_date }}</td>
							<td>{{ $entry->title }}</td>
							<td>{{ $entry->description }}</td>
							<td>{{ $entry->category->name }}</td>
							<td>
								<div class="dropdown show">
									<span role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
											<path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
										  </svg>
									</span>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									  <a class="dropdown-item" href="{{ route('entries.show', $entry) }}">View</a>
									  <a class="dropdown-item" href="{{ route('entries.edit', $entry) }}">Edit</a>
									  <form action="{{ route('entries.destroy', $entry) }}" method="post">
										  @method('delete')
										  @csrf
										  <button type="submit" class="dropdown-item" href="{{ route('entries.edit', $entry) }}">Delete</button>
									  </form>
									</div>
								  </div>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="4" class="text-center">
								<span>
									No entry found
									<a href="{{ route('entries.create') }}" >Add an entry</a>
								</span>
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
