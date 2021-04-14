@extends('layouts.app')

@section('content')
    <index :entries="{{ $entries }}" :dates="{{ $entriesDate }}"></index>
@endsection
