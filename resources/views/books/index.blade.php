@extends('layouts.app')

@section('content')
  <books v-bind:books=" {{ $books }}"></books>
@endsection