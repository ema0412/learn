<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#eeedf0] text-[#1f1f1f]">
<header class="h-10 bg-black">
    <div class="mx-auto flex h-full w-full max-w-[1200px] items-center justify-between px-3 sm:px-6">
        <div class="flex items-center gap-1 text-white">
            <span class="text-sm font-black italic leading-none tracking-tight">GT</span>
            <span class="text-sm font-extrabold leading-none tracking-tight">COACHTECH</span>
        </div>
        @auth
            <nav class="flex items-center gap-4 text-[10px] font-medium text-white sm:gap-6 sm:text-xs">
                @if(auth()->user()->is_admin)
                    <a class="hover:opacity-80" href="{{ route('admin.attendance.list') }}">勤怠一覧</a>
                    <a class="hover:opacity-80" href="{{ route('admin.staff.list') }}">スタッフ一覧</a>
                    <a class="hover:opacity-80" href="{{ route('request.list') }}">申請一覧</a>
                @else
                    <a class="hover:opacity-80" href="{{ route('attendance.index') }}">勤怠</a>
                    <a class="hover:opacity-80" href="{{ route('attendance.list') }}">勤怠一覧</a>
                    <a class="hover:opacity-80" href="{{ route('request.list') }}">申請</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline">@csrf<button class="hover:opacity-80">ログアウト</button></form>
            </nav>
        @endauth
    </div>
</header>

<main class="mx-auto w-full max-w-[960px] px-4 py-8 sm:px-6 sm:py-10">
    @if(session('message'))
        <p class="mx-auto mb-4 w-full max-w-[680px] rounded bg-emerald-100 px-4 py-2 text-xs text-emerald-800 sm:text-sm">{{ session('message') }}</p>
    @endif

    @if($errors->any())
        <div class="mx-auto mb-4 w-full max-w-[680px] rounded bg-rose-100 px-4 py-2 text-xs text-rose-700 sm:text-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
