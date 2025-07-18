@extends('auth.layout')

@section('content')
  <h5 class="card-title">Autenticação</h5>

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group row">
      <div class="col-md-12">
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="icon ion-email"></i>
            </div>
          </div>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                 value="{{ old('email') }}" required autocomplete="email" placeholder="E-Mail" autofocus>
          @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-12">
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="icon ion-locked"></i>
            </div>
          </div>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                 name="password" required autocomplete="current-password" placeholder="Senha">

          @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-12">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember"
                 id="remember" {{ old('remember') ? 'checked' : '' }}>
          <label class="form-check-label" for="remember">
            Lembrar-me
          </label>
        </div>
      </div>
    </div>

    <div class="form-group row mb-0">
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">
          Entrar
        </button>

        @if (Route::has('password.request'))
          <a class="btn btn-link" href="{{ route('password.request') }}">
            Esqueçeu sua senha?
          </a>
        @endif
      </div>
    </div>
  </form>
@endsection
