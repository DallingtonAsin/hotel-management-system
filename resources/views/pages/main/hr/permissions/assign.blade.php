@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Assign Permissions</h5>
        </div>
        <div class="card-body">
              @include('pages.main.messages.response')
            <div class="card border border-default">
                <div class="card-body">
                    <form action="{{ route('permissions.assign') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label><span class="text-danger pr-1">*</span>Staff Name</label>
                            <select name="staff_id" class="form-control">
                                <option value="">Select Staff Member</option>
                                @foreach ($staff_members as $member)
                                    <option value="{{ $member->id }}" {{ old('staff_id') == $member->id ? 'selected' : '' }}>{{ $member->first_name }} {{ $member->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><span class="text-danger pr-1">*</span>Choose Permissions</label><br>
                            <div class="permission-grid">
                            @foreach ($permissions as $permission)
                                <div>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                </div>
                            @endforeach
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Assign Permissions</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
