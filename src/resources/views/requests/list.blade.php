@extends('layout')
@section('content')
<h1>申請一覧 ({{ $status === 'pending' ? '承認待ち' : '承認済み' }})</h1>
<a href="?status=pending">承認待ち</a> | <a href="?status=approved">承認済み</a>
<ul>
@foreach($requests as $requestItem)
<li>{{ $requestItem->attendance->work_date->format('Y-m-d') }} - <a href="{{ route('request.detail',$requestItem) }}">詳細</a></li>
@endforeach
</ul>
@endsection
