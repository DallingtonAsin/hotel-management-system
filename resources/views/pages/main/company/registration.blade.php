@extends('layouts.master')

@section('content')
    @include('pages.main.messages.response')
    <div class="card card-primary">
        <div class="card-header bg-default">
            <span class="card-title text-dark">
                <?= isset($company) ? 'Edit company details' : 'Add company details' ?>
            </span>
        </div>

        <div class="card-body">
            {!! Form::open(['route' => ['companies.register', $company->is_registered ? $company->id : 0], 'method' => 'POST']) !!}

            <div class="form-group">
                <span><i class="text-danger pr-1">*</i>Name</span>
                <input type="text" class="form-control name " name="name"
                    value="<?= isset($company['name']) ? $company['name'] :  old('name')  ?>" placeholder="Enter company name" required>
            </div>

            <div class="row form-group">
                <div class="col-md-3">
                    <span><i class="text-danger pr-1">*</i>City</span>
                    <input type="text" class="form-control city " name="city"
                        value="<?= isset($company['city']) ? $company['city'] : old('city') ?>" placeholder="Enter city">
                </div>

                <div class="col-md-3">
                    <span>Street</span>
                    <input type="text" class="form-control street " name="street"
                        value="<?= isset($company['street']) ? $company['street'] : old('street') ?>" placeholder="Enter street">
                </div>

                <div class="col-md-3">
                    <span>State/Province</span>
                    <input type="text" class="form-control state " name="state"
                        value="<?= isset($company['state']) ? $company['state'] : '' ?>" placeholder="Enter state">
                </div>

                <div class="col-md-3">
                    <span>Zip/Postal Code</span>
                    <input type="text" class="form-control state " name="zip"
                        value="<?= isset($company['zip']) ? $company['zip'] : old('zip') ?>" placeholder="Enter zip">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-6">
                    <span><i class="text-danger pr-1">*</i>Phone Number</span>
                    <input type="text" class="form-control phone_number " name="phone_number"
                        value="<?= isset($company['phone_number']) ? $company['phone_number'] : old('phone_number') ?>" placeholder="Enter phone number">
                </div>

                <div class="col-md-6">
                    <span>Email</span>
                    <input type="email" class="form-control email " name="email"
                        value="<?= isset($company['email']) ? $company['email'] : old('email') ?>" placeholder="Enter company email">
                </div>
            </div>


            <div class="row form-group">
                <div class="col-md-6">
                    <span>Website url</span>
                    <input type="website_url" class="form-control website_url " name="website_url"
                        value="<?= isset($company['website_url']) ? $company['website_url'] : old('website_url') ?>" placeholder="Enter website url">
                </div>

                <div class="col-md-6">
                    <span><i class="text-danger pr-1">*</i>Category</span>
                    <select class="form-control" name="category">
                        <option value="">Select category</option>
                        @if(count($categories) > 0)
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" 
                             {{ isset($company['category']) ? $company['category'] == $category ? 'selected' : '' : '' }}
                              {{ old('category') == $category ? 'selected' : '' }}>
                              {{ $category }}
                            </option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-group">
                <span for="services"><i class="text-danger pr-1">*</i>Services</span>
                <select name="services[]" id="services-list" class="form-control" multiple>
                    <option value="">Select services</option>
                    @if(count($services) > 0)
                    @foreach ($services as $service)
                    <option value="{{ $service }}" {{ in_array($service, $company->services) ? 'selected' : '' }}>{{ $service }}</option>
                    @endforeach
                    @endif
                </select>


            </div>

            <div class="form-group">
                <span class="text-muted">Company Logo</span>
                <input type="file" class="form-control-file" name="logo" value="{{old('logo')}}">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-sm outline-none rounded-pill border-dark"
                    value="<?= isset($company) ? 'Update' : 'Submit' ?>">
            </div>

            {!! Form::close() !!}

        </div>
    </div>

    @if (session()->get('success'))
        <script>
            $(document).ready(function() {
                var div = ".response";
                var type = "success";
                var Login$erroror = "{{ session()->get('success') }}";
                ShowLoginErrorMessage(div, type, Login$erroror);
            });
        </script>
    @endif
@endsection
