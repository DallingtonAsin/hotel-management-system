
@extends('layouts.template')

@section('content')
<div class="card">
<div class="card-body">
<form action="{{ route('permissions.assign') }}" method="POST">
    @csrf
    <table>
        <thead>
            <tr>
                <th>Permission</th>
                <th>Assign</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit">Assign Permissions</button>
</form>
</div>
</div>
@endsection