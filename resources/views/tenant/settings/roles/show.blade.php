@extends('tenant.layout')

@section('content')
<section class="content-header">
    <h1>
        Roles
    </h1>
</section>
<section class="content">
    <div class="card card-primary">
        <div class="card-body">
            <div class="row" style="padding-left: 20px">
                <!-- Name Field -->
                <div class="form-group">
                    {!! html()->label('Name:', 'name') !!}
                    <p>{{ $role->name }}</p>
                </div>

                <!-- Roles Id Field -->
                <div class="form-group">
                    {!! html()->label('Roles Id:', 'role_id') !!}
                    <p>{{ $role->role_id }}</p>
                </div>

                <div class="form-group">
                    <strong>Permissions:</strong>

                    @if(!empty($rolePermissions))
                    @foreach($rolePermissions as $v)
                    <label class="label label-success">{{ $v->name }},</label>
                    @endforeach
                    @endif
                </div>


                <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</section>
@endsection
