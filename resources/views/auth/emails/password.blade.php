<h5 class="card-title">Resetar senha</h5>

<div>
  Clique aqui para resetar sua senha: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
</div>
