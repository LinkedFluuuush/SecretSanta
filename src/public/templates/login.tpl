{include file='header.tpl'}
<div style="padding: 3rem 1.5rem; text-align: center;">

    {if $error}
        <div class="alert alert-danger" role="alert">
            <strong>Nous n'avons pas pu vous identifier.</strong> Votre nom d'utilisateur ou votre mot de passe est incorrect.
        </div>
    {/if}

    <form class="form-signin" method="POST" action="/login">
        <h2 class="form-signin-heading">Identifiez-vous</h2>
        <label for="inputEmail" class="sr-only">Adresse e-mail</label>
        <input type="email" name="mail" id="inputEmail" class="form-control" placeholder="Adresse e-mail" required autofocus> 
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label> <input type="checkbox" value="remember-me"> Se souvenir de moi </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
    </form>

</div>
{include file='footer.tpl'}
