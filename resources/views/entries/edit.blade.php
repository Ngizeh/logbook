@extends('layouts.app')

@section('content')
    <edit :categories =" {{ $categories }}" :entry ="{{ $entry }}"></edit>
@endsection
