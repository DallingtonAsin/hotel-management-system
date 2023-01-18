@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Staff Permissions</h5>
        </div>
        <div class="card-body">
              @include('pages.main.messages.response')
            <div class="card border border-default">
                <div class="card-body">
                    <form action="{{ route('staff.permissions.update', $staff->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="permission-grid">
                            @foreach($permissions as $permission)
                                <div>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ $staff->hasPermission($permission->name) ? 'checked' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Update Permissions</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
