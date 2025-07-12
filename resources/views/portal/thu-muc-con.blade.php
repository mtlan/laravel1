@extends('portal.layouts.app')

@section('content')
    {{-- @livewire('dm-thu-muc-con') --}}
    <livewire:dm-thu-muc-con :slugCha="$slugCha" />
@endsection