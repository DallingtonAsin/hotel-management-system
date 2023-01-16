@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Permissions</strong>
                <span class="badge badge-info total_departments">
                    @isset($total_permissions)
                        {{ number_format($total_permissions) }}
                    @endisset
                </span>
            </h6>

            <a href="{{ route('staff-permissions.create') }}" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewDepartment">
                <i class="fa fa-plus-circle pr-1"></i>Assign Permissions</a>
        </div>

        <div class="card-body">

            <div class="table table-sm table-responsive">

                <table class="table table-bordered table-hover permissions-table" id="permissions-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Staff Names</th>
                            <th>Permission</th>
                            <th>Has Access</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('staff.permissions.ajax.fetch'));
        const cat = 'permissions';
        const token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript">
        $(document).ready(function() {


            //code that displays results of the table index()
            let table = $('#permissions-table');
            let title = "List of assigned permissions in the system";
            let columns = [1, 2, 3, 4];
            let dataColumns = [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'staff_name',
                    name: 'staff_name'
                },
            
                {
                    data: 'permission_name',
                    name: 'permission_name'
                },

                {
                    data: 'is_active',
                    name: 'is_active'
                },
           
            ];

            makeDataTable(table, title, columns, dataColumns);

  
        });
    </script>
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
@endsection
