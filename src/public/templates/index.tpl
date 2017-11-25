{include file='header.tpl'}
<div style="padding: 3rem 1.5rem; text-align: center;">

    {if $user}
        <h1>Hello {$user->getAppUserFirstname()} {$user->getAppUserName()} !</h1>
    {else}
        <h1>Hello you !</h1>
    {/if}

    <p class="lead">Ce site est encore en construction. Cette page sera
        bientôt disponible !</p>

</div>
{include file='footer.tpl'}
