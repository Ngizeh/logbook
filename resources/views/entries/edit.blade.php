@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<h4 class="text-center pt-4">Edit Entry</h4>
				<form class="form-group px-4" method="post" action="{{ route('entries.update', $entry) }}">
					@csrf
					@method('patch')
					<div class="form-group">
						<label for="title">Title:</label>
						<input type="text" class="form-control" name="title" value="{{ old('entry') ?? $entry->title }}" id="title">
						<span class="text-danger">{{ $errors->first('title') }}</span>
					</div>
					<div class="form-group">
						<label for="type">Category:</label>
						<select name="category_id" id="category_id" class="form-control">
							<option selected disabled>Choose your category</option>
							@foreach ($categories as $category )
								<option value="{{ $category->id }}" {{ old('category_id', $category->id) == $entry->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
							@endforeach
						</select>
						<span class="text-danger">{{ $errors->first('category_id') }}</span>
					</div>
					<div class="form-group">
						<label for="description">Description:</label>
						<textarea type="text" class="form-control" name="description" id="description">{{ old('entry') ?? $entry->description}}</textarea>
						<span class="text-danger">{{ $errors->first('description') }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<button type="submit" class="btn btn-primary">Submit</button>
						<a href="{{ route('entries.index') }}" class="btn btn-link">Cancel</a>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>

@endsection