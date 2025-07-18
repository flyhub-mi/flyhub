@extends('tenant.layout')

@section('content')
    <section class="content-header">
        <h1>
            User
        </h1>
   </section>
   <div class="content">
       @include('tenant.partials.errors')
       <div class="card card-primary">
           <div class="card-body">
               <div class="row">
                   {!! html()->modelForm($user, 'PATCH', route('users.update', $user->id)) !!}

                        @include('tenant.settings.users.fields')

                   {!! html()->form()->close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
