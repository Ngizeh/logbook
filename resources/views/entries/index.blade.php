@extends('layouts.app')

@section('content')
    <index :weekly-entries="{{ $weeklyEntries }}" :dates="{{ $entriesDate }}"></index>
@endsection
