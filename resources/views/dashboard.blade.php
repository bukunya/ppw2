<form method="POST" action="/logout">
    @csrf
    <button type="submit">Logout</button>
</form>
{{-- {{ dd(session()->all()) }} --}}
{{ Auth::user()->name }}