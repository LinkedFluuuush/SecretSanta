<!doctype html>
<html>
<head>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="/css/bootstrap.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="/css/signin.css">

<title>Secret Santa !</title>
<style>
body {
	padding-top: 5rem;
}
</style>
<link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="/">Secret Santa !</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {if $page == "index"}active{/if}"><a class="nav-link" href="/">Accueil {if $page == "index"}<span class="sr-only">(current)</span>{/if}
                </a></li>
                <li class="nav-item {if $page == "list"}active{/if}"><a class="nav-link" href="/list">Ma liste de cadeaux {if $page == "list"}<span class="sr-only">(current)</span>{/if}
                </a></li>
                <li class="nav-item {if $page == "gifts"}active{/if}"><a class="nav-link" href="/gifts">Mes cadeaux à acheter {if $page == "gifts"}<span class="sr-only">(current)</span>{/if}
                </a></li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Père noël
                        secret</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item active" href="#">Organiser un père noël secret</a> <a class="dropdown-item" href="#">Mes pères noëls secrets</a>
                    </div></li>
            </ul>
            {if isset($user)}
            <ul class="navbar-nav float-right">
                <li class="nav-item {if $page == "list"}active{/if} float-right" ><a class="nav-link" href="/user/{$user->getAppUserId()}">{$user->getAppUserFirstname()} {$user->getAppUserName()}{if $page ==
                        "user"}<span class="sr-only">(current)</span>{/if}
                </a></li>
            </ul>
            <a class="btn btn-outline-info my-2 my-sm-0 mr-sm-2" href="/logout" id="logout">Déconnexion</a>
            {else}
            <form class="form-inline my-2 my-lg-0 nav-form" action="/login" method="POST">
                <input class="form-control mr-sm-2" placeholder="Adresse e-mail" aria-label="Adresse e-mail" type="email" name="mail" id="mail" required /> <input class="form-control mr-sm-2"
                    placeholder="Mot de passe" aria-label="Mot de passe" type="password" name="password" id="password" required
                /> <input type="hidden" name="redirect" id="redirect" value="{$current_page}" />
                <button class="btn btn-outline-success my-2 my-sm-0 mr-sm-2" type="submit" id="login" name="login">Connexion</button>
            </form>
            <a class="btn btn-outline-info my-2 my-sm-0 mr-sm-2" href="/signin" id="signin">Inscription</a>
            {/if}
        </div>
    </nav>
    <main role="main" class="container">