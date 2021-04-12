@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-header">
					<div class="row">
                        <div class="col-md-6">
                            <select name="" id="" class="form-control">
                                @foreach($entriesDate as $date)
                                    <option value="{{ $date }}">Week Ending {{ $date }}</option>
                                @endforeach
                            </select>
                        </div>
						<div class="col-md-6 text-right">
							<a href="{{ route('entries.create') }}" class="btn btn-success">Add</a>
						</div>
					</div>
				</div>
				@include('entries.table')
			</div>
		</div>
	</div>
</div>

@endsection
