@extends('portal.layouts.app')

@section('content')
    {{-- @livewire('dm-thu-vien-anh') --}}
    <livewire:dm-thu-vien-anh :slugCha="$slugCha" :slugCon="$slugCon" />
@endsection