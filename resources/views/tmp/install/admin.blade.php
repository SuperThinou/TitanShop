@extends('templates.default')

@section('page.title', 'Titan Shop - Welcome')

@section('page.content')
    <div id="homepage" class="container-fluid d-flex flex-column justify-content-center" style="min-height:100vh;">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-8 col-lg-6">

                @if(!empty($errors->any()))
                @include('components.alerts.error', ['errors' => $errors->all()])
                @endif

                <div class="bg-light border shadow-sm p-3 my-4">
                    <h1 class="h4">Votre boutique en ligne est presque prête !</h1>
                    <p>
                        Il ne nous reste plus qu'à créer votre compte d'administrateur.
                    </p>
                    <form action="{{ route('settings.updateOrCreate') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-6 form-group">
                                <label for="firstname">Prénom</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" aria-describedby="helpFirstname">
                                <small id="helpFirstname" class="form-text text-muted">Votre prénom.</small>
                            </div>

                            <div class="col-12 col-lg-6 form-group">
                                <label for="lastname">Nom de famille</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="helpLastname">
                                <small id="helpLastname" class="form-text text-muted">Votre nom de famille.</small>
                            </div>

                            <div class="col-12 col-lg-6 form-group">
                                <label for="pseudo">Pseudo</label>
                                <input type="text" class="form-control" name="pseudo" id="pseudo" aria-describedby="helpPseudo">
                                <small id="helpPseudo" class="form-text text-muted">Il vous servira pour vous connecter.</small>
                            </div>

                            <div class="col-12 col-lg-6 form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="helpEmail">
                                <small id="helpEmail" class="form-text text-muted">Il pourra aussi vous servir à vous connecter,
                                    mais aussi pour recevoir des notifications.</small>
                            </div>

                            <div class="col-12 col-lg-6 form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control" name="password" id="password" aria-describedby="helpPassword">
                                <small id="helpPassword" class="form-text text-muted">Veuillez entrer un mot de passe d'au moins 8 caractères.</small>
                            </div>

                            <div class="col-12 col-lg-6 form-group">
                                <label for="password_confirm">Confirmation de mot de passe</label>
                                <input type="password" class="form-control" name="password_confirm" id="password_confirm" aria-describedby="helpPasswordConfirm">
                                <small id="helpPasswordConfirm" class="form-text text-muted">Retapez votre mot de passe par sécurité.</small>
                            </div>

                            <div class="col-6 text-left">
                                <a class="btn btn-outline-dark" href="{{ route('index') }}" role="button">Retour</a>
                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
