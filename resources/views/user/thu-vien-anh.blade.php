@extends('layouts/app')
@section('space-work')
    {{-- @livewire('thu-vien-anh') --}}
    <livewire:thu-vien-anh :slugCha="$slugCha" :slugCon="$slugCon" />
@endsection
